<?php

namespace App\Http\Controllers;

use app\Doctrine\ORM\Entity\Order;
use app\Doctrine\ORM\Entity\Payment;
use app\Doctrine\ORM\Entity\PaymentType;
use app\Doctrine\ORM\Repository\PaymentRepository;
use App\Http\Requests\PaymentIndexRequest;
use app\Utils\Utils;
use DateTime;
use Doctrine\ORM\EntityManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use function Laravel\Prompts\alert;

class PaymentController extends Controller {

    protected EntityManager $entityManager;
    protected PaymentRepository $repository;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
        $this->repository = ($entityManager->getRepository(Payment::class));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(PaymentIndexRequest $request) {
        // Get the validated data
        $validatedData = $request->validated();

        // This should ideally be done through the route /payments/{id}
        // and not with a header.
        if ($request->hasHeader("x-change-details")) {
            $paymentId = $validatedData["paymentId"];
            $payment = $this->repository->find($paymentId);
            return $this->getPaymentInfoAsJson($payment);
        }

        // Get the search parameters from validated data
        $page = $validatedData['page'];
        $search = $validatedData['search'];
        $searchBy = $validatedData['searchby'];

        // If no filters are applied.
        if (strlen($search) == 0) {
            $paginator = $this->repository->retrievePaginated(10, 1);
            // Get the total number of pages
            $pages = $paginator->lastPage();
            // Get the paginator with the right page
            $paginator = $this->repository->retrievePaginated(10, $page);

            // Get the payments
            $payments = $paginator->items();
            
            // Refresh the table if requested
            if ($request->hasHeader("x-refresh-table")) {
                return response(view('components.tables.payment-table')->with('payments', $payments),
                    200, [
                        "x-total-pages" => $pages,
                        "x-is-empty" => $paginator->total() == 0
                    ]);
            }

            // Return the view with payments
            $messageHeader = Session::get("messageHeader");
            $messageType = Session::get("messageType");
            return view('payments.index')->with(compact("payments", "pages", "page", "messageHeader", "messageType"));
        }

        // Get the repository
        $repository = $this->repository;

        // Apply the search filters
        $payment = null;
        switch ($searchBy) {
            case "order-id":
                $orderId = intval($search);
                $repository = $repository->withOrderId($orderId);
                break;
            case "payment-id":
                $paymentId = intval($search);
                $payment = $repository->find($paymentId);
                break;
        }

        // Return the view if a single payment has been searched for
        if ($payment != null) {
            return response(
                view("components.tables.payment-table")->with("payments", [$payment]),
                200,
                ["x-total-pages" => 1, "x-is-empty" => false]
            );
        }

        // TODO: APPLY ORDERING

        // Get the paginator
        $paginator = $repository->retrievePaginated(10, 1);
        // Get total of pages
        $pages = $paginator->lastPage();

        if ($page <= 0) {
            $page = 1;
        }
        if ($page > $pages) {
            $page = $pages;
        }

        // Get to the right page
        $paginator = $repository->retrievePaginated(10, $page);
        $payments = $paginator->items();

        if ($request->HasHeader("x-refresh-table")) {
            return response(
                view('components.tables.payment-table')->with('payments', $payments),
                200,
                [
                    "x-total-pages" => $pages,
                    "x-is-empty" => $paginator->total() == 0
                ]
            );
        }

        $messageHeader = Session::get("messageHeader");
        $messageType = Session::get("messageType");
        return view('payments.index')->with(compact("payments", "pages", "page","messageHeader", "messageType"));
    }

    /**
     * Get the payment info as json.
     */
    public function getPaymentInfoAsJson(Payment $payment): string {
        return json_encode(array(
            "paymentId" => $payment->getPaymentId(),
            "orderId" => $payment->getOrder()->getOrderId(),
            "paymentDate" => $payment->getPaymentDate()->format("Y / m / d"),
            "amount" => $payment->getAmount(),
            "type" => $payment->getType(),
            "method" => $payment->getMethod(),
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View {
        $orderId = $request->input("orderId");
        return view("payments.create")->with(compact("orderId"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse {
        $validatedData = $request->validate([
            "order-id" => "required|integer|min:1",
            "payment-date-input" => "nullable|date|date_format:Y-m-d",
            "amount" => "required|numeric",
            "type-select" => "required|string",
            "method" => "required|string",
        ]);

        $validationErrors = $this->validatePaymentInputData($validatedData, true);
        if (!empty($validationErrors)) {
            return redirect()->back()->withErrors($validationErrors)->withInput();
        }

        $orderRepository = $this->entityManager->getRepository(Order::class);

        $orderId = intval($validatedData["order-id"]);
        $order = $orderRepository->find($orderId);

        $paymentType = PaymentType::tryFrom(strtoupper($validatedData["type-select"]));
        $paymentDate =  DateTime::createFromFormat("Y-m-d", $validatedData["payment-date-input"]);


        $payment = new Payment(
            $validatedData["amount"],
            $paymentType,
            $validatedData["method"],
            $paymentDate,
            $order,
        );

        $this->repository->insertPayment($payment);

        $messageHeader = "Created Payment";
        $messageType= "create-message-header";
        return redirect("/payments")->with(compact("messageHeader", "messageType"));
    }

    public function validatePaymentInputData(array $data, bool $isCreate): array {
        $errors = [];

        if ($isCreate) {
            $orderRepository = $this->entityManager->getRepository(Order::class);
            $orderId = intval($data["order-id"]);
            if ($orderRepository->find($orderId) === null) {
                $errors["order-id"] = "The order ID does not match an existing order";
            }
        }

        $paymentDate = DateTime::createFromFormat("Y-m-d", $data["payment-date-input"]);
        if ($paymentDate != false && !Utils::validateDateInPastOrNow($paymentDate)) {
            $errors["payment-date-input"] = "The payment date must be in the past or present.";
        }

        if (!Utils::validatePositiveAmount($data["amount"])) {
            $errors["amount"] = "The amount cannot be a negative number.";
        }

        if (PaymentType::tryFrom(strtoupper($data["type-select"])) === null) {
            $errors["type-select"] = "The payment type is not one of the accepted values";
        }

        if (!Utils::validatePaymentMethod($data["method"])) {
            $errors["method"] = "The method is not well formatted.";
        }
        return $errors;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View {
        $payment = $this->repository->find($id);
        return view("payments.edit")->with("payment", $payment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse {
        $validatedData = $request->validate([
            "payment-date-input" => "nullable|date|date_format:Y-m-d",
            "amount" => "required|numeric",
            "type-select" => "required",
            "method" => "required|string",
        ]);

        $validationErrors = $this->validatePaymentInputData($validatedData, false);
        if (!empty($validationErrors)) {
            return redirect()->back()->withErrors($validationErrors)->withInput();
        }

        $payment = $this->repository->find($id);

        $paymentType = PaymentType::tryFrom(strtoupper($validatedData["type-select"]));
        $paymentDate =  DateTime::createFromFormat("Y-m-d", $validatedData["payment-date-input"]);

        $payment->setAmount($validatedData["amount"]);
        $payment->setMethod($validatedData["method"]);
        $payment->setPaymentDate($paymentDate);
        $payment->setType($paymentType);

        $this->repository->updatePayment($payment);

        $messageHeader = "Edited Payment $id";
        $messageType= "edit-message-header";
        return redirect("/payments")->with(compact("messageHeader", "messageType"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        $payment = $this->repository->find($id);
        $this->repository->deletePayment($payment);
        $messageHeader = "Edited Payment $id";
        $messageType= "delete-message-header";
        return redirect("/payments")->with(compact("messageHeader", "messageType"));
    }
}
