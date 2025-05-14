<?php

namespace App\Http\Controllers;

use app\Doctrine\ORM\Entity\Payment;
use app\Doctrine\ORM\Repository\PaymentRepository;
use Doctrine\ORM\EntityManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{

    protected EntityManager $entityManager;
    protected PaymentRepository $repository;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
        $this->repository = ($entityManager->getRepository(Payment::class));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->hasHeader("x-change-details")) {
            $paymentId = $request->input("paymentId");
            $payment = $this->repository->find($paymentId);
            return json_encode(array(
                "paymentId" => $payment->getPaymentId(),
                "orderId"=> $payment->getOrder()->getOrderId(),
                "paymentDate"=> $payment->getPaymentDate()->format("Y / m / d"),
                "amount"=> $payment->getAmount(),
                "type"=> $payment->getType(),
                "method"=> $payment->getMethod(),
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
    public function create(Request $request): View
    {
        $orderId = $request->input("orderId");
        return view("payments.create")->with(compact("orderId"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validateData = $request->validate([
            "order-id"=> "required",
            "payment-date"=> "",
            "amount"=> "required",
            "type"=> "required",
            "method"=> "required",
        ]);
        return redirect("/payments");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $payment = $this->repository->find($id);
        return view("payments.edit")->with("payment", $payment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validateData = $request->validate([
            "order-id"=> "required",
            "payment-date"=> "",
            "amount"=> "required",
            "type"=> "required",
            "method"=> "required",
        ]);
        return redirect("/payments");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
