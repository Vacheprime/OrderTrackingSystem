<?php

namespace App\Http\Controllers;

use app\Doctrine\ORM\Entity\Order;
use app\Doctrine\ORM\Repository\OrderRepository;
use Doctrine\ORM\EntityManager;
use Illuminate\Http\Request;

class OrdersController extends Controller
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
    public function index()
    {

        $orders = $this->repository->getOrdersByStatusAscPaginated(10);
        return view('orders.index')->with('orders', $orders->items());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
