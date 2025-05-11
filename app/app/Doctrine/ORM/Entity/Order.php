<?php

declare(strict_types = 1);

namespace app\Doctrine\ORM\Entity;

use app\Doctrine\ORM\Repository\OrderRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\GeneratedValue;

use app\Utils\Utils;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;

use InvalidArgumentException;
use LogicException;

require_once(dirname(dirname(dirname(__DIR__)))."/Utils/Utils.php");
require_once("Address.php");
require_once("Client.php");
require_once("Employee.php");
require_once("Product.php");

/**
 * Order class is used to represent orders stored in the database.
 */
#[Entity(repositoryClass: OrderRepository::class)]
#[Table("`order`")]
class Order {
    #[Id]
    #[Column(name: "order_id", type: Types::INTEGER), GeneratedValue("AUTO")]
    private ?int $orderId = null;
    /**  FORMAT: ORD-[ORDERID]-[CLIENTID]-[RANDOM4]
     * EX: ORD-1-1-U1AS
     * Should not be null, but has to because it is generated using PK ids,
     * and those are only generated after the Order is inserted into the
     * database.
     */
    #[Column(name: "reference_number", type: Types::STRING)]
    private ?string $referenceNumber = null;

    #[Column(name: "price", type: Types::DECIMAL, precision: 10, scale: 2)]
    private string $price;

    #[Column(name: "`status`", enumType: Status::class)]
    private Status $status;

    #[Column(name: "invoice_number", type: Types::STRING, nullable: true)]
    private ?string $invoiceNumber;

    #[Column(name: "creation_date", type: Types::DATETIME_MUTABLE)]
    private ?DateTime $creationDate = null;

    #[Column(name: "fabrication_start_date", type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTime $fabricationStartDate = null;

    #[Column(name: "estimated_install_date", type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTime $estimatedInstallDate = null;

    #[Column(name: "order_completed_date", type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTime $orderCompletedDate = null;

    #[ManyToOne(targetEntity: Client::class, inversedBy: "orders", cascade: ["persist"])]
    #[JoinColumn(name: "`client_id`", referencedColumnName: "`client_id`")]
    private Client $client;

    #[ManyToOne(targetEntity: Employee::class, cascade: ["persist"])]
    #[JoinColumn(name: "measured_by", referencedColumnName: "employee_id")]
    private Employee $measuredBy;

    #[OneToMany(targetEntity: Payment::class, mappedBy: "order", cascade: ["persist"])]
    private Collection $payments;

    #[OnetoOne(targetEntity: Product::class, mappedBy: "order", cascade: ["persist", "remove"])]
    private Product $product;

    /**
     * Default constructor for an order.
     *
     * It is important to create the product before the order, so
     * that it is possible to pass the product object in this constructor.
     * The product's order property will automatically be set to the new
     * order by this constructor.
     *
     * @param string $price The price of the order in
     * string format.
     * @param Status $status The order status of the order.
     * @param string $invoiceNumber The invoice number of the order.
     * @param ?DateTime $fabricationStartDate The date when the order
     * was put on fabrication.
     * @param ?DateTime $estimatedInstallDate The date when the order's
     * product is estimated to be installed.
     * @param ?DateTime $orderCompletedDate The date when the order
     * was completely fulfilled.
     * @param Client $client The client who placed the order.
     * @param Employee $measuredBy The employee who took the measurements
     * for the order.
     * @param Collection $payments The payments made to this order. It is
     * normal to have no payments for a new order.
     * @param Product $product The product of the order. The product's order
     * property is automatically set to the new order object by this constructor.
     */
    public function __construct(
        string $price,
        Status $status,
        string $invoiceNumber,
        ?DateTime $fabricationStartDate,
        ?DateTime $estimatedInstallDate,
        ?DateTime $orderCompletedDate,
        Client $client,
        Employee $measuredBy,
        Collection $payments,
        Product $product
    )
    {
        $this->setPrice($price);
        $this->setStatus($status);
        $this->setInvoiceNumber($invoiceNumber);
        $this->setFabricationStartDate($fabricationStartDate);
        $this->setEstimatedInstallDate($estimatedInstallDate);
        $this->setOrderCompletedDate($orderCompletedDate);
        $this->client = $client;
        $this->measuredBy = $measuredBy;
        $this->payments = $payments;
        // Assign the product to the order
        $this->product = $product;
        // Assign the order to the product
        $product->setOrder($this);
    }

    /**
     * Assign a reference number to this order.
     *
     * This method SHOULD NOT be called anywhere other than
     * inside the OrderRepository's insertOrder() method.
     * It is necessary to have this method to delay the creation
     * of a reference number because the reference number includes
     * the primary keys of this order and its client, both of which
     * are only available after being inserted into the order table.
     */
    public function assignReferenceNumber(): void {
        $randomChars = strtoupper(substr(md5(random_bytes(15)), 0, 5));
        $this->referenceNumber = "ORD-{$this->orderId}-{$this->client->getClientId()}-{$randomChars}";
    }

    /**
     * Get the order ID of this order.
     *
     * @return ?int The order ID of this order, if the order
     * exists in the database. Null if the order was never inserted.
     */
    public function getOrderId(): ?int {
        return $this->orderId;
    }

    /**
     * Get the reference number of this order.
     *
     * @return ?string The reference number of the order if the
     * order exists in the database. Null if the order was never inserted.
     */
    public function getReferenceNumber(): ?string {
        return $this->referenceNumber;
    }

    /**
     * Get the price of the order's product.
     *
     * @return string The price of the order's product.
     */
    public function getPrice(): string {
        return $this->price;
    }

    /**
     * Set the price of the order.
     *
     * @param string $price The new price for this order.
     * @throws InvalidArgumentException Exception thrown when the $price
     * argument is of invalid format.
     * @see \app\Utils\Utils::validatePositiveAmount() for the format of the
     * $price argument.
     */
    public function setPrice(string $price): void {
        if (!Utils::validatePositiveAmount($price)) {
            throw new InvalidArgumentException("The price must be greater than zero!");
        }
        $this->price = $price;
    }

    /**
     * Get the status of the order.
     *
     * @return Status The status of the order.
     */
    public function getStatus(): Status {
        return $this->status;
    }

    /**
     * Set the status of the order.
     *
     * @param Status $status The new status of the order.
     */
    public function setStatus(Status $status): void {
        $this->status = $status;
    }

    /**
     * Get the invoice number of the order.
     *
     * @return string|null The invoice number of the order.
     */
    public function getInvoiceNumber(): ?string {
        return $this->invoiceNumber;
    }

    /**
     * Set the invoice number of the order.
     *
     * @param string $invoiceNumber The new invoice number of the order.
     * @throws InvalidArgumentException Thrown when the $invoiceNumber argument
     * is of invalid format.
     * @see \app\Utils\Utils::validateInvoiceNumber() for the format of the invoice
     * number.
     */
    public function setInvoiceNumber(string $invoiceNumber): void {
        if (!Utils::validateInvoiceNumber($invoiceNumber)) {
            throw new InvalidArgumentException("The invoice number is invalid!");
        }
        $this->invoiceNumber = $invoiceNumber;
    }

    /**
     * Get the creation date of the order.
     *
     * @return ?DateTime The creation date of the order if the order
     * exists in the database. Null if the order was not yet inserted.
     */
    public function getCreationDate(): ?DateTime {
        return $this->creationDate;
    }

    /**
     * Set the creation date of the order to the current date.
     *
     * This method SHOULD NOT be called anywhere other than inside
     * the OrderRepository's insertOrder() method.
     *
     * @throws LogicException Thrown when the order was already inserted in the database,
     * which means that it was already created some time in the past.
     */
    public function setCreationDateNow(): void {
        if ($this->orderId != null) {
            throw new LogicException("The creation date cannot be set to the current time, as the order was already created.");
        }
        $this->creationDate = new DateTime("now");
    }

    /**
     * Get the fabrication start date of the order.
     *
     * @return ?DateTime The fabrication start date of the order. Null
     * if the order has not reached the fabrication stage yet.
     */
    public function getFabricationStartDate(): ?DateTime {
        return $this->fabricationStartDate;
    }

    /**
     * Set the fabrication start date of the order.
     *
     * @param ?DateTime $startDate The fabrication start date of order.
     * @throws InvalidArgumentException Thrown when the start date is set in
     * the future in relation to the current date and time.
     * @see \app\Utils\Utils::validateDateInPastOrNow() for the validation of the
     * $startDate argument.
     */
    public function setFabricationStartDate(?DateTime $startDate): void {
        if ($startDate == null) {
            $this->fabricationStartDate = null;
            return;
        }
        if (!Utils::validateDateInPastOrNow($startDate)) {
            throw new InvalidArgumentException("The start date must be set in the past or present!");
        }
        $this->fabricationStartDate = $startDate;
    }

    /**
     * Get the estimated installation date of the order.
     *
     * @return ?DateTime The estimated installation date of the order. Null
     * if no estimation has been given to the order.
     */
    public function getEstimatedInstallDate(): ?DateTime {
        return $this->estimatedInstallDate;
    }

    /**
     * Set the estimated installation date of the order.
     *
     * @param ?DateTime $date The new estimated installation date of the order.
     * @throws InvalidArgumentException Thrown when the $date argument is set in
     * the past or present.
     * @see \app\Utils\Utils::validateDateInFuture() for the validation of the $date
     * argument.
     */
    public function setEstimatedInstallDate(?DateTime $date): void {
        if ($date == null) {
            $this->estimatedInstallDate = null;
            return;
        }
        if (!Utils::validateDateInFuture($date)) {
            throw new InvalidArgumentException("The estimated installation date must be in the future!");
        }
        $this->estimatedInstallDate = $date;
    }

    /**
     * Get the completion date of the order.
     *
     * @return ?DateTime The order completion date. Null if the
     * order has not been completed yet.
     */
    public function getOrderCompletedDate(): ?DateTime {
        return $this->orderCompletedDate;
    }

    /**
     * Set the order completion date of the order.
     *
     * @param ?DateTime $date The new order completion date of the order.
     * @throws InvalidArgumentException Thrown when the $date argument is set
     * in the future.
     * @see \app\Utils\Utils::validateDateInPastOrNow() for the validation of the
     * $date argument.
     */
    public function setOrderCompletedDate(?DateTime $date): void {
        if ($date == null) {
            $this->orderCompletedDate = null;
            return;
        }
        if (!Utils::validateDateInPastOrNow($date)) {
            throw new InvalidArgumentException("The order completion date must be in the past or present!");
        }
        $this->orderCompletedDate = $date;
    }

    /**
     * Get the client that placed this order.
     *
     * @return Client The client that placed this order.
     */
    public function getClient(): Client {
        return $this->client;
    }

    /**
     * Get the employee that took the measurements for this order's product.
     *
     * @return Employee The employee that took the measurements for this order's product.
     */
    public function getMeasuredBy(): Employee {
        return $this->measuredBy;
    }

    /**
     * Get the payments that were made for this order.
     *
     * @return Collection The payments that were made for this order.
     */
    public function getPayments(): Collection {
        return $this->payments;
    }

    /**
     * Get the product of this order.
     *
     * @return Product The product of this order.
     */
    public function getProduct(): Product {
        return $this->product;
    }
}

/**
 * Enum Status
 *
 * Represents the different stages of a client's order.
 */
enum Status: string {
    /**
     * The MEASURING stage is the stage when the order has been
     * confirmed, but no materials have been ordered yet. The company
     * is waiting on measurements.
     */
    case MEASURING = "MEASURING";

    /**
     * The ORDERING_MATERIAL stage is the stage when the material
     * has been ordered, but it is still shipping. The company
     * is waiting on the material to arrive.
     */
    case ORDERING_MATERIAL = "ORDERING_MATERIAL";

    /**
     * The FABRICATING stage is the stage when the order
     * is being fabricated.
     */
    case FABRICATING = "FABRICATING";

    /**
     * The READY_TO_HANDOVER stage is the stage when the order
     * has been fabricated, but is waiting on the client to come
     * pick it up or on the company to install the product.
     */
    case READY_TO_HANDOVER = "READY_TO_HANDOVER";

    /**
     * The INSTALLED stage is a final/completion stage when
     * the product was installed by the company.
     */
    case INSTALLED = "INSTALLED";

    /**
     * The PICKED_UP stage is a final/completion stage when the
     * product was picked up by the client.
     */
    case PICKED_UP = "PICKED_UP";
}
