<?php

namespace App\Http\Controllers;

use app\Doctrine\ORM\Entity\Account;
use app\Doctrine\ORM\Entity\Address;
use app\Doctrine\ORM\Entity\Employee;
use app\Doctrine\ORM\Repository\EmployeeRepository;
use App\Http\Requests\EmployeeCreateRequest;
use App\Http\Requests\EmployeeIndexRequest;
use app\Utils\Utils;
use Doctrine\ORM\EntityManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

use function PHPSTORM_META\map;

class EmployeeController extends Controller
{

    protected EntityManager $entityManager;
    protected EmployeeRepository $repository;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
        $this->repository = ($entityManager->getRepository(Employee::class));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(EmployeeIndexRequest $request)
    {
        // Get the validated data
        $validatedData = $request->validated();

        if ($request->hasHeader("x-change-details")) {
            $employeeId = intval($validatedData["employeeId"]);
            $employee = $this->repository->find($employeeId);
            return $this->getEmployeeInfoAsJson($employee);
        }

        $page = $validatedData["page"];
        $search = $validatedData["search"];
        $searchBy = $validatedData["searchby"];
        
        // If no filters are applied.
        if (strlen($search) == 0) {
            // Get the paginator
            $paginator = $this->repository->retrievePaginated(10, 1);
            // Get the total number of pages
            $pages = $paginator->lastPage();
            // Get the paginator with the right page
            $paginator = $this->repository->retrievePaginated(10, $page);

            // Get the employees
            $employees = $paginator->items();

            // Refresh the table if requested
            if ($request->hasHeader("x-refresh-table")) {
                return response(view("components.tables.employee-table")->with("employees", $employees),
                    200, [
                        "x-total-pages" => $pages,
                        "x-is-empty" => $paginator->total() == 0
                    ]);
            }

            // Return the whole view with payments
            $messageHeader = Session::get("messageHeader");
            $messageType = Session::get("messageType");
            return view('employees.index')->with(compact("employees", "pages", "page", "messageHeader", "messageType"));
        }

        // Get the repository
        $repository = $this->repository;

        // Apply the search filters
        $employee = null;
        switch ($searchBy) {
            case "employee-id":
                $employeeId = intval($search);
                $employee = $repository->find($employeeId);
                break;
            case "name":
                $repository = $repository->searchByName($search);
                break;
            case "position":
                $repository = $repository->searchByPosition($search);
                break;
        }

        // Return the view if a single employee has been searched for.
        if ($employee != null) {
            return response(
                view("components.tables.employee-table")->with("employees", [$employee]),
                200,
                ["x-total-pages" => 1, "x-is-empty" => false]
            );
        }

        // TODO: APPLY ORDERING

        // Get the paginator
        $paginator = $repository->retrievePaginated(10, 1);
        // Get the total of pages
        $pages = $paginator->lastPage();

        // Change the bounds of the page variable
        if ($page <= 0) {
            $page = 1;
        }
        if ($page > $pages) {
            $page = $pages;
        }

        // Get the paginator to the right page
        $paginator = $repository->retrievePaginated(10, $page);
        // Get the employees
        $employees = $paginator->items();

        // Refresh the table if requested
        if ($request->HasHeader("x-refresh-table")) {
            return response(
                view('components.tables.employee-table')->with('employees', $employees),
                200,
                [
                    "x-total-pages" => $pages,
                    "x-is-empty" => $paginator->total() == 0
                ]
            );
        }

        // Return the full page with search params
        $messageHeader = Session::get("messageHeader");
        $messageType = Session::get("messageType");
        return view('employees.index')->with(compact("employees", "pages", "page", "messageHeader", "messageType"));
    }

    public function getEmployeeInfoAsJson(Employee $employee): string
    {
        return json_encode(array(
            "employeeId" => $employee->getEmployeeId(),
            "initials"=> $employee->getInitials(),
            "firstName"=> $employee->getFirstName(),
            "lastName"=> $employee->getLastName(),
            "position"=> $employee->getPosition(),
            "email"=> $employee->getAccount()->getEmail(),
            "phoneNumber"=> $employee->getPhoneNumber(),
            "addressStreet"=> $employee->getAddress()->getStreetName(),
            "addressAptNum"=> $employee->getAddress()->getAppartmentNumber(),
            "postalCode"=> $employee->getAddress()->getPostalCode(),
            "area"=> $employee->getAddress()->getArea(),
            "accountStatus"=> $employee->getAccount()->isAccountEnabled(),
            "adminStatus"=> $employee->getAccount()->isAdmin(),
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view("employees.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeCreateRequest $request): RedirectResponse
    {
        // Get the validated data from the request
        $validatedData = $request->validated();

        // Create the employee's address
        $address = new Address(
            $validatedData["address-street"],
            $validatedData["address-apt-num"],
            $validatedData["postal-code"],
            $validatedData["area"],
        );

        // Create the employee's account
        $account = new Account(
            $validatedData["email"],
            $validatedData["password"],
            false,
            false,
            false,
        );

        // Create the employee
        $employee = new Employee(
            $validatedData["first-name"],
            $validatedData["last-name"],
            $validatedData["phone-number"],
            $address,
            $validatedData["initials"],
            $validatedData["position"],
            $account,
        );

        // Insert the employee into the database
        $this->repository->insertEmployee($employee);

        // Return a success message
        $messageHeader = "Create Employee";
        $messageType= "create-message-header";
        return redirect("/employees")->with(compact("messageHeader", "messageType"));
    }

    public function validateEmployeeInputData(array $data): array {
        $errors = [];

        if (!Utils::validateInitials($data["initials"])) {
            $errors["initials"] = "The Initials aren't formatted well.";
        }

        if (!Utils::validateName($data["first-name"])) {
            $errors["first-name"] = "This is not a name.";
        }

        if (!Utils::validateName($data["last-name"])) {
            $errors["last-name"] = "This is not a name.";
        }

        if (!Utils::validatePosition($data["position"])) {
            $errors["position"] = "This is not a possible position";
        }

        if (!Utils::validateEmail($data["email"])) {
            $errors["email"] = "The Email isn't formatted correctly.";
        }

        if (!Utils::validatePhoneNumber($data["phone-number"])) {
            $errors["phone-number"] = "The Phone Number isn't formatted correctly.";
        }

        if (!Utils::validateStreetName($data["address-street"])) {
            $errors["address-street"] = "This is not a possible street name";
        }

        if (!Utils::validateAptNumber($data["address-apt-num"])) {
            $errors["address-apt-num"] = "This is not a possible apartment number.";
        }

        if (!Utils::validatePostalCode($data["postal-code"])) {
            $errors["postal-code"] = "This is not a possible postal code.";
        }

        if (!Utils::validateArea($data["area"])) {
            $errors["area"] = "This is not a possible area.";
        }

        return $errors;
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
    public function edit(Employee $employee): View
    {
        return view("employees.edit")->with(compact("employee"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validatedData = $request->validate([
            "initials"=> "required|string",
            "first-name"=> "required|string",
            "last-name" => "required|string",
            "position"=> "required|string",
            "email"=> "required|email",
            "phone-number"=> "required|string",
            "address-street"=> "required|string",
            "address-apt-num"=> "required|numeric",
            "postal-code"=> "required|string",
            "area"=> "required|string",
            "account-status-select"=>"nullable|string",
            "admin-status-select"=>"nullable|string",
        ]);

        $validationErrors = $this->validateEmployeeInputData($validatedData);
        if (!empty($validationErrors)) {
            return redirect()->back()->withErrors($validationErrors)->withInput();
        }

        $employee = $this->repository->find($id);

        $employee->getAddress()->setStreetName($validatedData["address-street"]);
        $employee->getAddress()->setAppartmentNumber($validatedData["address-apt-num"]);
        $employee->getAddress()->setPostalCode($validatedData["postal-code"]);
        $employee->getAddress()->setArea($validatedData["area"]);

        if (strtolower($validatedData["admin-status-select"]) == "disabled") {
            $adminStatus = false;
        }
        if (strtolower($validatedData["admin-status-select"]) == "enabled") {
            $adminStatus = true;
        }
        if (strtolower($validatedData["account-status-select"]) == "disabled") {
            $accountStatus = false;
        }
        if (strtolower($validatedData["account-status-select"]) == "enabled") {
            $accountStatus = true;
        }

        $employee->getAccount()->setEmail($validatedData["email"]);
        $employee->getAccount()->setIsAdmin($adminStatus);
        $employee->getAccount()->setAccountStatus($accountStatus);

        $employee->setFirstName($validatedData["first-name"]);
        $employee->setLastName($validatedData["last-name"]);
        $employee->setPhoneNumber($validatedData["phone-number"]);
        $employee->setInitials($validatedData["initials"]);
        $employee->setPosition($validatedData["position"]);

        $this->repository->updateEmployee($employee);

        $messageHeader = "Edit Employee $id";
        $messageType= "edit-message-header";
        return redirect("/employees")->with(compact("messageHeader", "messageType"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
