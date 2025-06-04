<?php

namespace App\Http\Controllers;

use Doctrine\ORM\EntityManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use app\Doctrine\ORM\Entity\Employee;
use App\Http\Requests\AccountUpdateRequest;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{

    public function index(Request $request, EntityManager $em) {
        // Get the authenticated user
        $employeeInfo = $request->session()->get('employee');

        // Fetch the employee entity using the ID from the session
        $employee = $em->find(Employee::class, $employeeInfo['employeeID']);


        $messageHeader = Session::get('messageHeader');
        $messageType = Session::get('messageType');
        return view("user.account")->with(compact("employee", "messageHeader", "messageType"));
    }


    public function update(AccountUpdateRequest $request, EntityManager $em) {
        // Get the employee repository
        $employeeRepository = $em->getRepository(Employee::class);
        // Get validated data from the request
        $validatedData = $request->validated();
        // Get the authenticated user
        $employeeInfo = $request->session()->get('employee');

        // Fetch the employee entity using the ID from the session
        $employee = $employeeRepository->find($employeeInfo['employeeID']);

        // Update employee details
        $employee->setInitials($validatedData["initials"]);
        $employee->setFirstName($validatedData["first-name"]);
        $employee->setLastName($validatedData["last-name"]);
        $employee->getAccount()->setEmail($validatedData["email"]);
        $employee->setPhoneNumber($validatedData["phone-number"]);
        $employee->getAddress()->setStreetName($validatedData["street"]);
        $employee->getAddress()->setAppartmentNumber($validatedData["apartment-number"]);
        $employee->getAddress()->setPostalCode($validatedData["postal-code"]);
        $employee->getAddress()->setArea($validatedData["area"]);

        // Handle password update if provided
        if ($validatedData["password"] !== null && !empty($validatedData['password'])) {
            $employee->getAccount()->setPassword($validatedData['password']);
        }

        // Persist changes to the database
        try {
            $employeeRepository->updateEmployee($employee);
            Log::info('Employee account updated successfully', ['id' => $employeeInfo['employeeID']]);

            $messageHeader = "Account Updated";
            $messageType = "edit-message-header";
            return redirect("/account")->with(compact("messageHeader", "messageType"));
        } catch (\Exception $e) {
            Log::error('Error updating employee account', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => 'Failed to update account.']);
        }
    }
}
