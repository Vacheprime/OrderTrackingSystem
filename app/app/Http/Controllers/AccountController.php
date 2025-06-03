<?php

namespace App\Http\Controllers;

use Doctrine\ORM\EntityManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use app\Doctrine\ORM\Entity\Employee;

class AccountController extends Controller
{

    public function index(Request $request, EntityManager $em) {
        // Get the authenticated user
        $employeeInfo = $request->session()->get('employee');

        // Fetch the employee entity using the ID from the session
        $employee = $em->find(Employee::class, $employeeInfo['employeeID']);

        return view("user.account")->with("employee", $employee);
    }

    public function update() {

    }
}
