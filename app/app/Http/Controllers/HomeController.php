<?php

namespace App\Http\Controllers;

use app\Doctrine\ORM\Entity\Activity;
use app\Doctrine\ORM\Repository\ActivityType;
use app\Doctrine\ORM\Entity\Order;
use app\Doctrine\ORM\Repository\ActivityRepository;
use app\Doctrine\ORM\Repository\OrderRepository;
use Doctrine\ORM\EntityManager;
use Illuminate\Http\Request;
use SortOrder;

class HomeController extends Controller
{
    protected EntityManager $entityManager;
    protected ActivityRepository $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = ($entityManager->getRepository(Activity::class));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request) {
        // Get the employee and his ID
        $id = 3; // Testing value while authentication is not completed.
        $limit = 15;

        // Fetch edited activities of the employee
        $editedActivities = $this->repository
            ->withEmployeeId($id)
            ->filterByType(ActivityType::EDITED)
            ->sortByLogDate(SortOrder::DESCENDING)
            ->limit($limit)
            ->retrieve();
        // Fetch viewed activites of the employee
        $viewedActivites = $this->repository
            ->withEmployeeId($id)
            ->filterByType(ActivityType::VIEWED)
            ->sortByLogDate(SortOrder::DESCENDING)
            ->limit($limit)
            ->retrieve();
        
        // Map activities to orders
        $editedOrders = array_map(fn(Activity $activity) => $activity->getOrder(), $editedActivities);
        $viewedOrders = array_map(fn(Activity $activity) => $activity->getOrder(), $viewedActivites);

        return view("home")->with("orders", [$viewedOrders, $editedOrders]);
    }
}
