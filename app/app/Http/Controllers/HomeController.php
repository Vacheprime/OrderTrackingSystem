<?php

namespace App\Http\Controllers;

use app\Doctrine\ORM\Entity\Order;
use app\Doctrine\ORM\Repository\OrderRepository;
use Doctrine\ORM\EntityManager;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected EntityManager $entityManager;
    protected OrderRepository $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = ($entityManager->getRepository(Order::class));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request) {
        $nextOrders = $this->repository->retrievePaginated(10, 1);
        $recentOrders = $this->repository->retrievePaginated(10, 1);
        return view("home")->with("orders", [$nextOrders, $recentOrders]);
    }
}
