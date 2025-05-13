<?php

namespace App\Http\Controllers;

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
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;
use function Termwind\parse;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    protected EntityManager $entityManager;
    protected OrderRepository $repository;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
        $this->repository = ($entityManager->getRepository(Order::class));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->hasHeader("x-change-details")) {
            $orderId = $request->input("orderId");
            $order = $this->repository->find($orderId);
            return json_encode(array(
                "orderId" => $order->getOrderId(),
                "clientId"=> $order->getClient()->getClientId(),
                "measuredBy"=> $order->getMeasuredBy()->getInitials(),
                "referenceNumber"=> $order->getReferenceNumber(),
                "invoiceNumber"=> $order->getInvoiceNumber() ?? "No invoice associated.",
                "totalPrice"=> $order->getPrice(),
                "orderStatus"=> $order->getStatus(),
                "fabricationStartDate"=> $order->getFabricationStartDate() == null ? "-" : $order->getFabricationStartDate()->format("Y / m / d") ,
                "installationStartDate"=> $order->getEstimatedInstallDate() == null ? "-" : $order->getEstimatedInstallDate()->format("Y / m / d"),
                "pickUpDate"=> $order->getOrderCompletedDate() == null ? "-" : $order->getOrderCompletedDate()->format("Y / m / d"),
//                "materialName"=> $order->getProduct()->getMaterialName() ?? "null",
//                "slabHeight"=> $order->getProduct()->getSlabHeight() ?? "null",
//                "slabWidth"=> $order->getProduct()->getSlabWidth() ?? "null",
//                "slabThickness"=> $order->getProduct()->getSlabThickness() ?? "null",
//                "slabSquareFootage"=> $order->getProduct()->getSlabSquareFootage() ?? "null",
//                "fabricationPlanImage"=> $order->getProduct()->getPlanImagePath() ?? "null",
//                "productDescription"=> $order->getProduct()->getProductDescription() ?? "null",
//                "productNotes"=> $order->getProduct()->getProductNotes() ?? "null",
            ));
        }

        $page = $request->input('page', 1);
        $search = $request->input('search', "");
        $searchBy = $request->input('searchby', "order-id");
        $orderBy = $request->input('orderby', "newest");
        $pagination = $this->repository->retrievePaginated(1, $page);
        $orders = $pagination->items();
        $pages = $pagination->lastPage();

        if ($request->HasHeader("x-refresh-table")) {
            return view('components.tables.order-table')->with('orders', $orders);
        }
        return view('orders.index')->with(compact("orders", "pages", "page"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('orders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = array_merge(
            // Default value
            ["fabrication-image-input" => null], 
        
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
        ));
        Log::info($validatedData);
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

    public function validateOrderInputData(array $data): array {
        $errors = [];
        // ORDER DETAILS VALIDATION
        // Get the client and employee repositories
        $clientRepository = $this->entityManager->getRepository(Client::class);
        $employeeRepository = $this->entityManager->getRepository(Employee::class);
        // Validate Client Id
        $clientId = intval($data["client-id"]);
        if ($clientRepository->find($clientId) === null) {
            $errors["client-id"] = "The client ID does not match an existing employee.";
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
        }        // Validate 
        if ($data["slab-square-footage"] !== null && !Utils::validateSlabSquareFootage($data["slab-square-footage"])) {
            $errors["slab-square-footage"] = "The slab square footage is of invalid format.";
        }
        // Validate the sink type
        if ($data["sink-type"] !== null && !Utils::validateMaterial($data["sink-type"])) {
            $errors["sink-type"] = "The sink type is of invalid format.";
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
    public function edit(string $id): View
    {
        $order = $this->repository->find($id);
        return view("orders.edit")->with('order', $order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
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
    public function destroy(string $id)
    {
        //
    }
}
