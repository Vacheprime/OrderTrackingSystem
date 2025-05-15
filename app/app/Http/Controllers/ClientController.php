<?php

namespace App\Http\Controllers;

use app\Doctrine\ORM\Entity\Client;
use app\Doctrine\ORM\Repository\ClientRepository;
use Doctrine\ORM\EntityManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    protected EntityManager $entityManager;
    protected ClientRepository $repository;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
        $this->repository = ($entityManager->getRepository(Client::class));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->hasHeader("x-change-details")) {
            $clientId = $request->input("clientId");
            $client = $this->repository->find($clientId);
            return json_encode(array(
                "clientId" => $client->getClientId(),
                "firstName"=> $client->getFirstName(),
                "lastName"=> $client->getLastName(),
                "referenceNumber"=> $client->getClientReference() ?? "",
                "phoneNumber"=> $client->getPhoneNumber(),
                "address"=> $client->getAddress()->getAppartmentNumber() . $client->getAddress()->getStreetName(),
                "postalCode"=> $client->getAddress()->getPostalCode(),
                "area"=> $client->getAddress()->getArea(),
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
        $clients = $pagination->items();

        if ($request->HasHeader("x-refresh-table")) {
            return view('components.tables.client-table')->with('clients', $clients);
        }

        return view('clients.index')->with(compact("clients", "pages", "page"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view("clients.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validateData = $request->validate([
            "first-name"=> "required",
            "last-name"=> "required",
            "reference-number"=> "required",
            "phone-number"=> "required",
            "address"=> "required",
            "postal-code"=> "required",
            "city"=> "required",
            "province"=> "required",
            "area"=> "required",
        ]);
        return redirect("/clients");
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
        $client = $this->repository->find($id);
        return view("clients.edit")->with("client", $client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validateData = $request->validate([
            "first-name"=> "required",
            "last-name"=> "required",
            "reference-number"=> "required",
            "phone-number"=> "required",
            "address"=> "required",
            "postal-code"=> "required",
            "city"=> "required",
            "province"=> "required",
            "area"=> "required",
        ]);
        return redirect("/clients");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
