<?php

namespace App\Http\Controllers;

use app\Doctrine\ORM\Entity\Client;
use app\Doctrine\ORM\Repository\ClientRepository;
use App\Http\Requests\ClientIndexRequest;
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
        Log::info($validatedData);
        Log::info($request->input());
        // Refresh the client side panel info
        if ($request->hasHeader("x-change-details")) {
            $clientId = $validatedData["clientId"];
            if (is_null($clientId)) {
                $clientId = 1;
            }
            $client = $this->repository->find($clientId);
            return $this->getClientInfoAsJson($client);
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
