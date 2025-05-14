<?php

namespace App\Http\Controllers;

use app\Doctrine\ORM\Entity\Employee;
use app\Doctrine\ORM\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
    public function index(Request $request)
    {
        if ($request->hasHeader("x-change-details")) {
            $employeeId = $request->input("employeeId");
            $employee = $this->repository->find($employeeId);
            return json_encode(array(
                "employeeId" => $employee->getEmployeeId(),
                "initials"=> $employee->getInitials(),
                "firstName"=> $employee->getFirstName(),
                "lastName"=> $employee->getLastName(),
                "hiredDate"=> "",
                "position"=> $employee->getPosition(),
                "email"=> $employee->getAccount()->getEmail(),
                "phoneNumber"=> $employee->getPhoneNumber(),
                "address"=> $employee->getAddress()->getAddressId() . $employee->getAddress()->getStreetName(),
                "postalCode"=> $employee->getAddress()->getPostalCode(),
                "city"=> $employee->getAddress()->getArea(),
                "province"=> $employee->getAddress()->getArea(),
                "accountStatus"=> $employee->getAccount()->isAccountEnabled(),
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
        $employees = $pagination->items();

        if ($request->HasHeader("x-refresh-table")) {
            return view('components.tables.employee-table')->with('employees', $employees);
        }

        return view('employees.index')->with(compact("employees", "pages", "page"));
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
    public function store(Request $request): RedirectResponse
    {
        $validateData = $request->validate([
            "initials"=> "required",
            "first-name"=> "required",
            "last-name" => "required",
            "hired-date" => "",
            "position"=> "required",
            "email"=> "required",
            "phone-number"=> "required",
            "address"=> "required",
            "postal-code"=> "required",
            "city"=> "required",
            "province"=> "required",
        ]);
        return redirect("/employees");
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
        $employee = $this->repository->find($id);
        return view("employees.edit")->with(compact("employee"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validateData = $request->validate([
            "initials"=> "required",
            "first-name"=> "required",
            "last-name"=> "required",
            "email"=> "required",
            "phone-number"=> "required",
            "hired-date"=> "",
            "position"=> "required",
            "address"=> "required",
            "postal-code"=> "required",
            "city"=> "required",
            "province"=> "required",
            "account-status"=>""
        ]);
        return redirect("/employees");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
