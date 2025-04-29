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
    public function index(Request $request): View
    {
        $page = $request->input('page', 1);
        $search = $request->input('search', "");
        $searchBy = $request->input('searchby', "order-id");
        $orderBy = $request->input('orderby', "newest");
        $orders = $this->repository->retrievePaginated(10, $page);
        return view('clients.index')->with('clients', $orders->items());
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
        return redirect()->route("clients.index");
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
        return redirect()->route("clients.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
