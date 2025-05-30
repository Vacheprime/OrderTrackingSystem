<?php

namespace App\Http\Controllers;

use app\Doctrine\ORM\Entity\Client;
use app\Doctrine\ORM\Repository\ClientRepository;
use App\Http\Requests\ClientIndexRequest;
use App\Http\Requests\ClientUpdateRequest;
use Doctrine\ORM\EntityManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
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
    public function index(ClientIndexRequest $request)
    {
        // Get the validated data
        $validatedData = $request->validated();

        // This should idealy be done through the route /orders/{id}
        // and not with a header.
        // Refresh the client side panel info
        if ($request->hasHeader("x-change-details")) {
            $clientId = $validatedData["clientId"];
            $client = $this->repository->find($clientId);
            return $this->getClientInfoAsJson($client);
        }

        // Get the search parameters
        $page = $validatedData["page"];
        $search = $validatedData["search"];
        $searchBy = $validatedData["searchby"];

        // Get the repository
        $repository = $this->repository;

        // If no filters are applied.
        if (strlen($search) == 0) {
            // Get the paginator
            $paginator = $this->repository->retrievePaginated(10, 1);
            
            // Get the total number of pages
            $pages = $paginator->lastPage();

            // Get the clients
            $clients = $paginator->items();
            
            // Return only the table if requested
            if ($request->hasHeader("x-refresh-table")) {
                return response(
                    view('components.tables.client-table')->with('clients', $clients),
                    200,
                    ["x-total-pages" => $pages, "x-is-empty" => $paginator->total() == 0]
                );
            }

            // Return the page
            $messageHeader = Session::get("messageHeader");
            $messageType = Session::get("messageType");
            return view('clients.index')->with(compact("clients", "pages", "page", "messageHeader", "messageType"));
        }

        // Apply filters
        $client = null; // For client ID filtering
        switch ($searchBy) {
            // Filter by first or last name
            case "name":
                $repository = $repository->searchByName($search);
                break;
            // Filter by area
            case "area":
                $repository = $repository->searchByArea($search);
                break;
            case "client-id":
                // Get the client
                $client = $repository->find(intval($search));
            break;
        }

        // Check if filtering by client
        if ($client != null) {
            return response(
                view("components.tables.client-table")->with("clients", [$client]),
                200,
                ["x-total-pages" => 1, "x-is-empty" => false]
            );
        }

        // Get the paginator
        $paginator = $repository->retrievePaginated(10, 1);

        // Get the total pages
        $pages = $paginator->lastPage();

        // Create the pagination
        if ($page <= 0) {
            $page = 1;
        }
        if ($page > $pages) {
            $page = $pages;
        }

        // Refetch the paginator with the right page
        $pagination = $repository->retrievePaginated(10, $page);

        // Get the clients
        $clients = $pagination->items();

        // Refresh the table if requested
        if ($request->HasHeader("x-refresh-table")) {
            return response(
                view('components.tables.client-table')->with('clients', $clients),
                200,
                ["x-total-pages" => $pages, "x-is-empty" => $paginator->total() == 0]
            );
        }

        // Return whole index page
        $messageHeader = Session::get("messageHeader");
        $messageType = Session::get("messageType");
        return view('clients.index')->with(compact("clients", "pages", "page", "messageHeader", "messageType"));
    }

    private function getClientInfoAsJson(Client $client): string {
        return json_encode(array(
            "clientId" => $client->getClientId(),
            "firstName"=> $client->getFirstName(),
            "lastName"=> $client->getLastName(),
            "referenceNumber"=> $client->getClientReference() ?? "",
            "phoneNumber"=> $client->getPhoneNumber(),
            "addressStreet"=> $client->getAddress()->getStreetName(),
            "addressAptNum"=> $client->getAddress()->getAppartmentNumber(),
            "postalCode"=> $client->getAddress()->getPostalCode(),
            "area"=> $client->getAddress()->getArea(),
        ));
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

        $messageHeader = "Created Client";
        $messageType= "create-message-header";
        return redirect("/clients")->with(compact("messageHeader", "messageType"));
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
    public function edit(Client $client): View
    {
        return view("clients.edit")->with("client", $client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientUpdateRequest $request, Client $client): RedirectResponse
    {
        // Get the validated data
        $validatedData = $request->validated();

        // Get client's address
        $address = $client->getAddress();

        // Update the client's information
        $client->setFirstName($validatedData["first-name"]);
        $client->setLastName($validatedData["last-name"]);
        $client->setClientReference($validatedData["reference-number"]);
        $client->setPhoneNumber($validatedData["phone-number"]);
        $address->setStreetName($validatedData["street"]);
        $address->setAppartmentNumber($validatedData["apartment-number"]);
        $address->setPostalCode($validatedData["postal-code"]);
        $address->setArea($validatedData["area"]);

        // Persist the client to the database
        $this->repository->updateClient($client);
        
        // Redirect with confirmation
        $messageHeader = "Edit Client";
        $messageType= "edit-message-header";
        return redirect("/clients")->with(compact("messageHeader", "messageType"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
