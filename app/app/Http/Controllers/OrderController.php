<?php

namespace App\Http\Controllers;

use app\Doctrine\ORM\Entity\Order;
use app\Doctrine\ORM\Repository\OrderRepository;
use Doctrine\ORM\EntityManager;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;
use function Termwind\parse;

class OrderController extends Controller
{
    protected EntityManager $entityManager;
    protected OrderRepository $repository;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
        $this->repository = ($entityManager->getRepository(Order::class));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->hasHeader("x-change-details")) {
            $orderId = $request->input("orderId");
            $order = $this->repository->find($orderId);
            return json_encode(array(
                "objectId" => $order->getOrderId(),
                "clientId"=> $order->getClient()->getClientId(),
                "measuredBy"=> $order->getMeasuredBy()->getInitials(),
                "referenceNumber"=> $order->getReferenceNumber(),
//                "invoiceNumber"=> $order->getInvoiceNumber() ?? "null",
                "totalPrice"=> $order->getPrice() ?? "null",
                "orderStatus"=> $order->getStatus(),
                "fabricationStartDate"=> $order->getFabricationStartDate() == null ? "null" : $order->getFabricationStartDate()->format("Y/m/d") ,
                "installationStartDate"=> $order->getEstimatedInstallDate() == null ? "null" : $order->getEstimatedInstallDate()->format("Y/m/d"),
                "pickUpDate"=> $order->getOrderCompletedDate() == null ? "null" : $order->getOrderCompletedDate()->format("Y/m/d"),
//                "materialName"=> $order->getProduct()->getMaterialName() ?? "null",
//                "slabHeight"=> $order->getProduct()->getSlabHeight() ?? "null",
//                "slabWidth"=> $order->getProduct()->getSlabWidth() ?? "null",
//                "slabThickness"=> $order->getProduct()->getSlabThickness() ?? "null",
//                "slabSquareFootage"=> $order->getProduct()->getSlabSquareFootage() ?? "null",
//                "fabricationPlanImage"=> $order->getProduct()->getPlanImagePath() ?? "null",
//                "productDescription"=> $order->getProduct()->getProductDescription() ?? "null",
//                "productNotes"=> $order->getProduct()->getProductNotes() ?? "null",
            ));
        }


        $page = $request->input('page', 1);
        $search = $request->input('search', "");
        $searchBy = $request->input('searchby', "order-id");
        $orderBy = $request->input('orderby', "newest");
        $orders = $this->repository->retrievePaginated(10, $page);
        return view('orders.index')->with('orders', $orders->items());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('orders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        return redirect('orders.index');
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
        $order = $this->repository->find($id);
        return view("orders.edit")->with('order', $order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
//        $validatedData = $request->validate([
//            'client-id' => 'required|int',
//            'measured-by' => 'nullable|string',
//        ]);
//        $order = $this->repository->find($id);
//        $this->repository->updateOrder($order);
        return redirect()->route("orders.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
