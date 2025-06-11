<?php

namespace App\Http\Controllers;

use app\Doctrine\ORM\Entity\Order;
use app\Doctrine\ORM\Entity\Payment;
use app\Doctrine\ORM\Repository\PaymentRepository;
use App\Http\Requests\PaymentCreateRequest;
use App\Http\Requests\PaymentIndexRequest;
use App\Http\Requests\PaymentUpdateRequest;
use Doctrine\ORM\EntityManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

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
            $notificationMessage = Session::get("notificationMessage");
            $messageType = Session::get("messageType");
            return view('payments.index')->with(compact("payments", "pages", "page", "notificationMessage", "messageType"));
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

        $notificationMessage = Session::get("notificationMessage");
        $messageType = Session::get("messageType");
        return view('payments.index')->with(compact("payments", "pages", "page", "notificationMessage", "messageType"));
    }

    /**
     * Get the payment info as json.
     */
    public function getPaymentInfoAsJson(Payment $payment): string {
        return json_encode(array(
            "paymentId" => $payment->getPaymentId(),
            "orderId" => $payment->getOrder()->getOrderId(),
            "paymentDate" => $payment->getPaymentDate()->format("Y / m / d"),
            "amount" => $payment->getAmount() . " $",
            "type" => ucwords(strtolower($payment->getType()->value)),
            "method" => ucwords(strtolower($payment->getMethod())),
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
    public function store(PaymentCreateRequest $request): RedirectResponse {
        // Retrieve the validated data
        $validatedData = $request->validated();
        Log::info($validatedData);

        // Get the order repository
        $orderRepository = $this->entityManager->getRepository(Order::class);

        // Get the order
        $order = $orderRepository->find($validatedData["order-id"]);

        // Create the payment
        $payment = new Payment(
            $validatedData["amount"],
            $validatedData["type-select"],
            $validatedData["method"],
            $validatedData["payment-date-input"],
            $order,
        );

        // Insert the payment into the repository
        $this->repository->insertPayment($payment);

        // Return a success message
        $notificationMessage = "Payment Created";
        $messageType= "success";
        return redirect("/payments")->with(compact("notificationMessage", "messageType"));
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
    public function edit(Payment $payment): View {
        return view("payments.edit")->with("payment", $payment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentUpdateRequest $request, Payment $payment): RedirectResponse {
        // Get the validated data
        $validatedData = $request->validated();

        // Update the payment with the validated data
        $payment->setAmount($validatedData["amount"]);
        $payment->setMethod($validatedData["method"]);
        $payment->setPaymentDate($validatedData["payment-date-input"]);
        $payment->setType($validatedData["type-select"]);

        // Update the payment in the repository
        $this->repository->updatePayment($payment);

        // Return a success message
        $notificationMessage = "Edited Payment with ID {$payment->getPaymentId()}";
        $messageType= "success";
        return redirect("/payments")->with(compact("notificationMessage", "messageType"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment): RedirectResponse {
        // Save the payment ID for the notification
        $paymentId = $payment->getPaymentId();

        // Delete the payment from the repository
        $this->repository->deletePayment($payment);

        // Return a success message
        $notificationMessage = "Deleted Payment with ID {$paymentId}";
        $messageType= "error";
        return redirect("/payments")->with(compact("notificationMessage", "messageType"));
    }
}
