<?php

namespace App\Http\Controllers;

use app\Doctrine\ORM\Entity\Address;
use app\Doctrine\ORM\Entity\Order;
use app\Doctrine\ORM\Entity\Client;
use app\Doctrine\ORM\Entity\Employee;
use app\Doctrine\ORM\Entity\Product;
use app\Doctrine\ORM\Entity\Status;
use app\Doctrine\ORM\Repository\OrderRepository;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\OrderIndexRequest;
use App\Http\Requests\OrderUpdateRequest;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Illuminate\Support\Facades\Storage;
use SortOrder;

class OrderController extends Controller {
    protected EntityManager $entityManager;
    protected OrderRepository $repository;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
        $this->repository = ($entityManager->getRepository(Order::class));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(OrderIndexRequest $request) {
        // Get the validated data
        $validatedData = $request->validated();

        // Define default redirect url
        $defaultUrl = "/orders?page=1&orderby=status";

        // Return order information as JSON if requested.
        // Used for refreshing the order details when an order is
        // selected.
        if ($request->hasHeader("x-change-details")) {
            // Get the order
            $orderId = $validatedData["orderId"];
            if (is_null($orderId)) {
                $orderId = 1;
            }
            $order = $this->repository->find($orderId);
            // Return as json
            return $this->getOrderInfoAsJson($order);
        }

        // Get the search query parameters
        $page = $validatedData["page"];
        $search = $validatedData["search"];
        $searchBy = $validatedData["searchby"];
        $orderBy = $validatedData["orderby"];
        // Fetch the orders based on the query parameters
        $repository = $this->repository;

        // Add search filters if requested
        if (strlen($search) !== 0) {
            // Search by order Id
            switch ($searchBy) {
                case "order-id":
                    // Validate the order Id
                    $orderId = filter_var($search, FILTER_VALIDATE_INT);
                    if ($orderId === false) {
                        return response("The order id must be a number.", 300);
                    } else if ($orderId < 1) {
                        return response("The order id must be greater than zero.", 300);
                    }
                    // Fetch the result
                    $result = $repository->find($orderId);
                    $orders = [];
                    // Define params
                    $totalPages = 1;
                    $page = 1;
                    // Check if no results
                    if ($result === null) {
                        return response(view('components.tables.order-table')->with('orders', $orders), 200, ["x-total-pages" => "1"]);
                    }
                    // Return the result
                    $orders[] = $result;
                    return response(view('components.tables.order-table')->with('orders', $orders), 200, ["x-total-pages" => "1"]);
                    break;
                case "client-id":
                    // Validate the client Id
                    $clientId = filter_var($search, FILTER_VALIDATE_INT);
                    if ($clientId === false) {
                        return response("The client id must be a number.", 300);
                    } else if ($clientId < 1) {
                        return response("The client id must be greater than zero.", 300);
                    }
                    // Add query
                    $repository = $repository->withClientId($clientId);
                    break;
                case "area":
                    // Add query
                    $repository = $repository->searchByArea($search);
                    break;
                case "name":
                    // Add query
                    $repository = $repository->searchByName($search);
                    break;
            }
        }
        // Apply ordering
        if ($validatedData["orderby"] == "status") {
            $repository = $repository->sortByStatus(SortOrder::ASCENDING);
        } else if ($validatedData["orderby"] == "newest") {
            $repository = $repository->sortByCreationDate(SortOrder::DESCENDING);
        } else if ($validatedData["orderby"] == "oldest") {
            $repository = $repository->sortByCreationDate(SortOrder::ASCENDING);
        }

        // Get the paginator
        $paginator = $repository->retrievePaginated(10, 1);

        // Create the appropriate pagination
        $totalPages = $paginator->lastPage();
        if ($page <= 0) {
            $page = 1;
        }
        if ($page > $totalPages) {
            $page = $totalPages;
        }

        // Fetch the paginator with the right page
        $paginator = $repository->retrievePaginated(10, $page);
        // Get the orders
        $orders = $paginator->items();

        // Return only the html of the orders table if requested
        if ($request->HasHeader("x-refresh-table")) {
            return response(view('components.tables.order-table')->with('orders', $orders), 200, ["x-total-pages" => "$totalPages"]);
        }

        // Return the full orders page
        $messageHeader = Session::get("messageHeader");
        $messageType = Session::get("messageType");
        return view('orders.index')->with(compact("orders", "totalPages", "page", "messageHeader", "messageType"));
    }

    public function getOrderInfoAsJson(Order $order): string {
        return json_encode($order);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request) {
        $clientId = $request->input('clientId');
        $client = $request->input('client', 'new');
        return view('orders.create')->with(compact("clientId", "client"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateOrderRequest $request): RedirectResponse {
        // Determine whether the create request was made with a client id
        // or client info.
        if ($request->input("with-existing-client", "0") === "1") {
            // Store with the client ID
            return $this->storeWithClientId($request);
        }
        // Store with client information
        return $this->storeWithClientInfo($request);
    }

    public function storeWithClientInfo(CreateOrderRequest $request): RedirectResponse {
        $validatedData = $request->validated();
        
        // Create the address
        $address = new Address(
            $validatedData["street-name"],
            $validatedData["appartment-number"],
            $validatedData["postal-code"],
            $validatedData["area"]
        );

        // Create the client
        $client = new Client(
            $validatedData["first-name"],
            $validatedData["last-name"],
            $validatedData["phone-number"],
            $address,
            $validatedData["reference-number"]
        );

        // Get the employee repository
        $employeeRepository = $this->entityManager->getRepository(Employee::class);

        // Get the employee
        $employeeId = intval($validatedData["measured-by"]);
        $employee = $employeeRepository->find($employeeId);

        // Store the image plan
        $imageFilePath = null;
        if ($validatedData["fabrication-image-input"] !== null) {
            $imageFilePath = $validatedData["fabrication-image-input"]->store("fabrication_plan_images");
        }

        // Create the product
        $product = new Product(
            $validatedData["material-name"],
            $validatedData["slab-height"],
            $validatedData["slab-width"],
            $validatedData["slab-thickness"],
            $validatedData["slab-square-footage"],
            $imageFilePath,
            $validatedData["sink-type"],
            $validatedData["product-description"] ?? "",
            $validatedData["product-notes"] ?? ""
        );

        // Get the fabrication start date
        $fabricationStartDate = $validatedData["fabrication-start-date-input"];
        if ($fabricationStartDate !== null) {
            $fabricationStartDate = DateTime::createFromFormat("Y-m-d", $fabricationStartDate);
        }

        // Get the estimated installation date
        $estInstallDate = $validatedData["estimated-installation-date-input"];
        if ($estInstallDate !== null) {
            $estInstallDate = DateTime::createFromFormat("Y-m-d", $estInstallDate);
        }

        // Create the order
        $order = new Order(
            $validatedData["total-price"],
            Status::from(strtoupper($validatedData["order-status-select"])),
            $validatedData["invoice-number"],
            $fabricationStartDate,
            $estInstallDate,
            null,
            $client,
            $employee,
            new ArrayCollection(),
            $product
        );

        // Insert the order into the database
        $this->repository->insertOrder($order);

        // Redirect back to orders
        $messageHeader = "Created New Order";
        return redirect('/orders')->with(compact("messageHeader"));
    }

    public function storeWithClientId(CreateOrderRequest $request): RedirectResponse {
        // Get the validated data
        $validatedData = $request->validated();

        // Get the client and employee repositories
        $clientRepository = $this->entityManager->getRepository(Client::class);
        $employeeRepository = $this->entityManager->getRepository(Employee::class);

        // Get the client and employee based on id
        $clientId = intval($validatedData["client-id"]);
        $employeeId = intval($validatedData["measured-by"]);
        $client = $clientRepository->find($clientId);
        $employee = $employeeRepository->find($employeeId);

        // Store the image plan
        $imageFilePath = null;
        if ($validatedData["fabrication-image-input"] !== null) {
            $imageFilePath = $validatedData["fabrication-image-input"]->store("fabrication_plan_images");
        }

        // Create the product
        $product = new Product(
            $validatedData["material-name"],
            $validatedData["slab-height"],
            $validatedData["slab-width"],
            $validatedData["slab-thickness"],
            $validatedData["slab-square-footage"],
            $imageFilePath,
            $validatedData["sink-type"],
            $validatedData["product-description"] ?? "",
            $validatedData["product-notes"] ?? ""
        );

        // Get the fabrication start date
        $fabricationStartDate = $validatedData["fabrication-start-date-input"];
        if ($fabricationStartDate !== null) {
            $fabricationStartDate = DateTime::createFromFormat("Y-m-d", $fabricationStartDate);
        }

        // Get the estimated installation date
        $estInstallDate = $validatedData["estimated-installation-date-input"];
        if ($estInstallDate !== null) {
            $estInstallDate = DateTime::createFromFormat("Y-m-d", $estInstallDate);
        }

        // Create the order
        $order = new Order(
            $validatedData["total-price"],
            Status::from(strtoupper($validatedData["order-status-select"])),
            $validatedData["invoice-number"],
            $fabricationStartDate,
            $estInstallDate,
            null,
            $client,
            $employee,
            new ArrayCollection(),
            $product
        );

        // Insert the order into the database
        $this->repository->insertOrder($order);

        // Redirect back to orders
        $messageHeader = "Created New Order";
        $messageType = "create-message-header";
        return redirect('/orders')->with(compact("messageHeader", "messageType"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order): View {
        return view("orders.edit")->with('order', $order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderUpdateRequest $request, Order $order): RedirectResponse {
        $validatedData = $request->validated();

        // Get the product
        $product = $order->getProduct();

        // Update the image plan
        $newImage = $validatedData["fabrication-image-input"];
        if ($newImage !== null) {
            $oldImagePath = $product->getPlanImagePath();
            // Delete the old image
            if ($oldImagePath !== null) {
                Storage::delete($oldImagePath);
            }
            // Store the new image
            $imageFilePath = $newImage->store("fabrication_plan_images");
            $product->setPlanImagePath($imageFilePath);
        }

        // Update all product fields
        $product->setMaterialName($validatedData["material-name"]);
        $product->setSlabHeight($validatedData["slab-height"]);
        $product->setSlabWidth($validatedData["slab-width"]);
        $product->setSlabThickness($validatedData["slab-thickness"]);
        $product->setSlabSquareFootage($validatedData["slab-square-footage"]);
        $product->setSinkType($validatedData["sink-type"]);
        $product->setProductDescription($validatedData["product-description"]);
        $product->setProductNotes($validatedData["product-notes"]);

        // Get the fabrication start date
        $fabricationStartDate = $validatedData["fabrication-start-date-input"];
        if ($fabricationStartDate !== null) {
            $fabricationStartDate = DateTime::createFromFormat("Y-m-d", $fabricationStartDate);
        }

        // Get the estimated installation date
        $estInstallDate = $validatedData["estimated-installation-date-input"];
        if ($estInstallDate !== null) {
            $estInstallDate = DateTime::createFromFormat("Y-m-d", $estInstallDate);
        }

        // Update all order fields
        $order->setInvoiceNumber($validatedData["invoice-number"]);
        $order->setPrice($validatedData["total-price"]);

        // Set the estimated install date only if not the same
        if ($estInstallDate !== null) {
            $currentEstimatedDate = $order->getEstimatedInstallDate();
            if ($currentEstimatedDate !== null && $estInstallDate->format("Y-m-d") != $currentEstimatedDate->format("Y-m-d")) {
                $order->setEstimatedInstallDate($estInstallDate);
            }
        } else {
            $order->setEstimatedInstallDate($estInstallDate);
        }
        // Set the fabrication start date
        $order->setFabricationStartDate($fabricationStartDate);
        
        // Update the status field
        $newStatus = Status::from(strtoupper($validatedData["order-status-select"]));
        // Only update if changed
        if ($newStatus != $order->getStatus()) {
            $order->setStatus($newStatus);
            if ($newStatus == Status::INSTALLED || $newStatus == Status::PICKED_UP) {
                // Order has been completed
                $order->setOrderCompletedDate(new DateTime("now"));
            } else {
                // Order is not longer completed
                $order->setOrderCompletedDate(null);
            }
        }
        // Update
        $this->repository->updateOrder($order);
        // Return to order pages
        $messageHeader = "Edited Order {$order->getOrderId()}";
        $messageType = "edit-message-header";
        return redirect('/orders')->with(compact("messageHeader", "messageType"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        //
    }
}
