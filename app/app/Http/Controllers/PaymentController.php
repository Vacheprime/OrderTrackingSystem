<?php

namespace App\Http\Controllers;

use app\Doctrine\ORM\Entity\Order;
use app\Doctrine\ORM\Entity\Payment;
use app\Doctrine\ORM\Entity\PaymentType;
use app\Doctrine\ORM\Repository\PaymentRepository;
use app\Utils\Utils;
use DateTime;
use Doctrine\ORM\EntityManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
    public function index(Request $request) {
        if ($request->hasHeader("x-change-details")) {
            $paymentId = $request->input("paymentId");
            $payment = $this->repository->find($paymentId);
            return json_encode(array(
                "paymentId" => $payment->getPaymentId(),
                "orderId" => $payment->getOrder()->getOrderId(),
                "paymentDate" => $payment->getPaymentDate()->format("Y / m / d"),
                "amount" => $payment->getAmount(),
                "type" => $payment->getType(),
                "method" => $payment->getMethod(),
            ));
        }

        $page = $request->input('page', 1);
        $search = $request->input('search', "");
        $searchBy = $request->input('searchby', "order-id");
        $orderBy = $request->input('orderby', "newest");
        $pagination = $this->repository->retrievePaginated(10, 1);
        $pages = $pagination->lastPage();
        if ($page <= 0) {
            $page = 1;
        }
        if ($page > $pages) {
            $page = $pages;
        }
        $pagination = $this->repository->retrievePaginated(10, $page);
        $payments = $pagination->items();

        if ($request->HasHeader("x-refresh-table")) {
            return view('components.tables.payment-table')->with('payments', $payments);
        }

        return view('payments.index')->with(compact("payments", "pages", "page"));
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

        return redirect("/payments");
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

        return redirect("/payments");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        //
    }
}
