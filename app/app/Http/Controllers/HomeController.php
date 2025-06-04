<?php

namespace App\Http\Controllers;

use app\Doctrine\ORM\Entity\Activity;
use app\Doctrine\ORM\Entity\Employee;
use app\Doctrine\ORM\Entity\ActivityType;
use app\Doctrine\ORM\Repository\ActivityRepository;
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
        // Get the authenticated user
        $employeeInfo = $request->session()->get('employee');

        // Fetch the employee entity using the ID from the session
        $employee = $this->entityManager->find(Employee::class, $employeeInfo['employeeID']);
        $limit = 15; // Total number of activity records to display

        // Fetch edited activities of the employee
        $editedActivities = $this->repository
            ->withEmployeeId($employee->getEmployeeId())
            ->filterByType(ActivityType::EDITED)
            ->sortByLogDate(SortOrder::DESCENDING)
            ->limit($limit)
            ->retrieve();
        // Fetch viewed activites of the employee
        $viewedActivites = $this->repository
            ->withEmployeeId($employee->getEmployeeId())
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
