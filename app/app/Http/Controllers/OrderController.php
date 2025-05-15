<?php

namespace App\Http\Controllers;

use app\Doctrine\ORM\Entity\Address;
use app\Doctrine\ORM\Entity\Order;
use app\Doctrine\ORM\Entity\Client;
use app\Doctrine\ORM\Entity\Employee;
use app\Doctrine\ORM\Entity\Product;
use app\Doctrine\ORM\Entity\Status;
use app\Doctrine\ORM\Repository\ClientRepository;
use app\Doctrine\ORM\Repository\OrderRepository;
use app\Utils\Utils;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Exception;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;
use function Termwind\parse;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use SortOrder;
use function Termwind\render;

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
    public function index(Request $request) {
        // Define default values
        $defaultParams = [
            "page" => 1,
            "search" => "",
            "searchby" => "order-id",
            "orderby" => "status",
            "orderId" => 1
        ];
        // Define default redirect url
        $defaultUrl = "/orders?page={$defaultParams['page']}&orderby={$defaultParams['orderby']}";
        // Validate the input data
        $validatedData = array_merge(
        // Default values for parameters
            $defaultParams,
            // Add validation rules
            $request->validate(
                [
                    "page" => "nullable|int|min:1",
                    "search" => "nullable|string",
                    "searchby" => "nullable|string",
                    "orderby" => "nullable|string",
                    "orderId" => "nullable|int"
                ]
            )
        );
        Log::info($validatedData);
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
            Log::info("HERE");
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
                    Log::info("AREA");
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
        return view('orders.index')->with(compact("orders", "totalPages", "page"));
    }

    public function getOrderInfoAsJson(Order $order): string {
        return json_encode(array(
            "orderId" => $order->getOrderId(),
            "clientId" => $order->getClient()->getClientId(),
            "measuredBy" => $order->getMeasuredBy()->getInitials(),
            "referenceNumber" => $order->getReferenceNumber(),
            "invoiceNumber" => $order->getInvoiceNumber() ?? "No invoice associated.",
            "totalPrice" => $order->getPrice(),
            "orderStatus" => $order->getStatus(),
            "fabricationStartDate" => $order->getFabricationStartDate() == null ? "-" : $order->getFabricationStartDate()->format("Y / m / d"),
            "installationStartDate" => $order->getEstimatedInstallDate() == null ? "-" : $order->getEstimatedInstallDate()->format("Y / m / d"),
            "pickUpDate" => $order->getOrderCompletedDate() == null ? "-" : $order->getOrderCompletedDate()->format("Y / m / d"),
            "materialName" => $order->getProduct()->getMaterialName() ?? "-",
            "slabHeight" => $order->getProduct()->getSlabHeight() ?? "-",
            "slabWidth" => $order->getProduct()->getSlabWidth() ?? "-",
            "slabThickness" => $order->getProduct()->getSlabThickness() ?? "-",
            "slabSquareFootage" => $order->getProduct()->getSlabSquareFootage() ?? "-",
            "sinkType" => $order->getProduct()->getSinkType() ?? "-",
            "fabricationPlanImage" => $order->getProduct()->getPlanImagePath() ?? "-",
            "productDescription" => $order->getProduct()->getProductDescription() ?? "-",
            "productNotes" => $order->getProduct()->getProductNotes() ?? "-",
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request) {
        if ($request->hasHeader("x-add-client-panel")) {
            return view('components.client-panel')->render();
        } else if ($request->hasHeader("x-add-client-input")) {
            $name = "client-id";
            $labelText = "Client Id";
            $value = $request->input('clientId');
            return view('components.inputs.text-input-property', compact("name", "labelText", "value"))->render();
        }
        $clientId = $request->input('clientId');
        return view('orders.create')->with(compact("clientId"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse {
        // Determine whether the create request was made with a client id
        // or client info.
        if ($request->filled("client-id")) {
            // Store with the client ID
            return $this->storeWithClientId($request);
        }
        // Store with client information
        return $this->storeWithClientInfo($request);
    }

    public function storeWithClientInfo(Request $request): RedirectResponse {
        $validatedData = array_merge(
            [
                "appartment-number" => null,
                "reference-number" => null,
                "fabrication-image-input" => null
            ],
            $request->validate([
                // Order and Product fields
                "measured-by" => "required|integer|min:1",
                "invoice-number" => "nullable|string",
                "total-price" => "required|numeric",
                "order-status-select" => "required",
                "fabrication-image-input" => "nullable|file|mimes:jpg,jpeg,png,webp|max:10240",
                "fabrication-start-date-input" => "nullable|date|date_format:Y-m-d",
                "estimated-installation-date-input" => "nullable|date|date_format:Y-m-d",
                "material-name" => "nullable|string",
                "slab-height" => "nullable|string",
                "slab-width" => "nullable|string",
                "slab-thickness" => "nullable|string",
                "slab-square-footage" => "nullable|string",
                "sink-type" => "nullable|string",
                "product-description" => "nullable|string",
                "product-notes" => "nullable|string",
                // Client Fields
                "first-name" => "required|string",
                "last-name" => "required|string",
                "street-name" => "required|string",
                "appartment-number" => "nullable|string",
                "postal-code" => "required|string",
                "area" => "required|string",
                "reference-number" => "nullable|string",
                "phone-number" => "required|string"
            ]
        ));

        // Do additional validation
        $errors = [
            ...$this->validateClientInputData($validatedData),
            ...$this->validateOrderInputData($validatedData, false)
        ];
        // Return if errors found
        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }
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
        return redirect('/orders');
    }

    public function storeWithClientId(Request $request): RedirectResponse {
        $validatedData = array_merge(
            // Default values
            ["fabrication-image-input" => null],
            // Validated fields
            $request->validate([
                    "client-id" => "required|integer|min:1",
                    "measured-by" => "required|integer|min:1",
                    "invoice-number" => "nullable|string",
                    "total-price" => "required|numeric",
                    "order-status-select" => "required",
                    "fabrication-image-input" => "nullable|file|mimes:jpg,jpeg,png,webp|max:10240",
                    "fabrication-start-date-input" => "nullable|date|date_format:Y-m-d",
                    "estimated-installation-date-input" => "nullable|date|date_format:Y-m-d",
                    "material-name" => "nullable|string",
                    "slab-height" => "nullable|string",
                    "slab-width" => "nullable|string",
                    "slab-thickness" => "nullable|string",
                    "slab-square-footage" => "nullable|string",
                    "sink-type" => "nullable|string",
                    "product-description" => "nullable|string",
                    "product-notes" => "nullable|string",
                ]
            )
        );
        // Do additional validation on the incomming data
        $validationErrors = $this->validateOrderInputData($validatedData);
        if (!empty($validationErrors)) {
            return redirect()->back()->withErrors($validationErrors)->withInput();
        }

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
        return redirect('/orders');
    }

    public function validateOrderInputData(array $data, bool $checkClientId = true): array {
        $errors = [];
        // ORDER DETAILS VALIDATION
        // Get the client and employee repositories
        $clientRepository = $this->entityManager->getRepository(Client::class);
        $employeeRepository = $this->entityManager->getRepository(Employee::class);
        // Validate Client Id
        if ($checkClientId) {
            $clientId = intval($data["client-id"]);
            if ($clientRepository->find($clientId) === null) {
                $errors["client-id"] = "The client ID does not match an existing employee.";
            }
        }
        // Validate Employee Id
        $employeeId = intval($data["measured-by"]);
        if ($employeeRepository->find($employeeId) === null) {
            $errors["measured-by"] = "The employee ID does not match an existing client.";
        }
        // Validate invoice number
        if ($data["invoice-number"] !== null && !Utils::validateInvoiceNumber($data["invoice-number"])) {
            $errors["invoice-number"] = "The invoice number format is invalid.";
        }
        // Validate total price
        if (!Utils::validatePositiveAmount($data["total-price"])) {
            $errors["total-price"] = "The price format is invalid.";
        }
        // Validate order status
        if (Status::tryFrom(strtoupper($data["order-status-select"])) === null) {
            $errors["order-status"] = "The order status is not one of the accepted values.";
        }
        // DATE DETAILS VALIDATION
        // Validate fabrication start date
        $fabricationDate = DateTime::createFromFormat("Y-m-d", $data["fabrication-start-date-input"]);
        if ($fabricationDate != false && !Utils::validateDateInPastOrNow($fabricationDate)) {
            $errors["fabrication-start-date-input"] = "The fabrication start date must be in the past or present.";
        }
        // Validate installation start date
        $estInstallDate = DateTime::createFromFormat("Y-m-d", $data["estimated-installation-date-input"]);
        if ($estInstallDate != false && !Utils::validateDateInFuture($estInstallDate)) {
            $errors["estimated-installation-date-input"] = "The estimated install date must be in the future.";
        }

        // PRODUCT VALIDATION
        // Define groups of fields that should be validated together
        // Group of fields related to slab information
        $slabFields = [
            "material-name" => $data["material-name"],
            "slab-width" => $data["slab-width"],
            "slab-height" => $data["slab-height"],
            "slab-thickness" => $data["slab-thickness"],
            "slab-square-footage" => $data["slab-square-footage"]
        ];
        // Group of fields related to the completed product information
        $productFields = [...$slabFields, "sink-type" => $data["sink-type"]];

        // Validate that slab info exists if at least one field is entered
        // Check if all fields are present if at least one field has a value.
        if (Utils::arrayHasValue($slabFields)) {
            // Check if any field is null
            foreach ($slabFields as $name => $field) {
                if (is_null($field)) {
                    $errors[$name] = "This field cannot be left empty if slab information is specified.";
                }
            }
        }

        // Validate that either the slab info or the sink info is present.
        if (!Utils::arrayHasValue($productFields)) {
            foreach ($productFields as $name => $field) {
                $errors[$name] = "Either the slab or sink information must be filled out.";
            }
        }

        // Validate the material name
        if ($data["material-name"] !== null && !Utils::validateMaterial($data["material-name"])) {
            $errors["material-name"] = "The material name is of invalid format.";
        }
        // Validate the slab height
        if ($data["slab-height"] !== null && !Utils::validateSlabDimension($data["slab-height"])) {
            $errors["slab-height"] = "The slab height is of invalid format.";
        }
        // Validate slab width
        if ($data["slab-width"] !== null && !Utils::validateSlabDimension($data["slab-width"])) {
            $errors["slab-width"] = "The slab width is of invalid format.";
        }
        // Validate slab thickness
        if ($data["slab-thickness"] !== null && !Utils::validateSlabThickness($data["slab-thickness"])) {
            $errors["slab-thickness"] = "The slab thickness is of invalid format.";
        }
        // Validate the slab square footage
        if ($data["slab-square-footage"] !== null && !Utils::validateSlabSquareFootage($data["slab-square-footage"])) {
            $errors["slab-square-footage"] = "The slab square footage is of invalid format.";
        }
        // Validate the sink type
        if ($data["sink-type"] !== null && !Utils::validateMaterial($data["sink-type"])) {
            $errors["sink-type"] = "The sink type is of invalid format.";
        }
        return $errors;
    }

    public function validateClientInputData(array $data): array {
        // Define the errors array
        $errors = [];
        // Validate first name
        if (!Utils::validateName($data["first-name"])) {
            $errors["first-name"] = "The first name is of invalid format.";
        }
        // Validate the last name
        if (!Utils::validateName($data["last-name"])) {
            $errors["last-name"] = "The last name is of invalid format.";
        }
        // Validate the street name
        if (!Utils::validateStreetName($data["street-name"])) {
            $errors["street-name"] = "The street name is of invalid format.";
        }
        // Validate the appartment number
        if ($data["appartment-number"] !== null && !Utils::validateAptNumber($data["appartment-number"])) {
            $errors["appartment-number"] = "The appartment number is of invalid format.";
        }
        // Validate the postal code
        if (!Utils::validatePostalCode($data["postal-code"])) {
            $errors["postal-code"] = "The postal code is of invalid format.";
        }
        // Validate the area
        if (!Utils::validateArea($data["area"])) {
            $errors["area"] = "The area is of invalid format.";
        }
        // Validate the reference number
        if ($data["reference-number"] !== null && !Utils::validateClientReference($data["reference-number"])) {
            $errors["reference-number"] = "The reference number is of invalid format.";
        }
        // Validate the phone number
        if (!Utils::validatePhoneNumber($data["phone-number"])) {
            $errors["phone-number"] = "The phone number is of invalid format";
        }
        // Return the errors found
        return $errors;
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
    public function edit(string $id): View {
        $order = $this->repository->find($id);
        return view("orders.edit")->with('order', $order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse {
        $validateData = $request->validate([
            "client-id" => "required",
            "measured-by" => "required",
            "reference-number" => "required",
            "invoice-number" => "required",
            "total-price" => "required",
            "order-status" => "",
            "fabrication-image" => "",
            "fabrication-start-date" => "",
            "installation-start-date" => "",
            "pickup-start-date" => "",
            "material-name" => "required",
            "slab-height" => "required",
            "slab-width" => "required",
            "slab-thickness" => "required",
            "slab-square-footage" => "required",
            "sink-type" => "required",
            "product-description" => "required",
            "product-notes" => "required",
        ]);
//        $order = $this->repository->find($id);
//        $this->repository->updateOrder($order);
        return redirect("/orders");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        //
    }
}
