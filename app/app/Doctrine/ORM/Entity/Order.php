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

require_once(dirname(dirname(dirname(__DIR__)))."/Utils/Utils.php");
require_once("Address.php");
require_once("Client.php");
require_once("Employee.php");
require_once("Product.php");

#[Entity(repositoryClass: OrderRepository::class)]
#[Table("`order`")]
class Order {
    #[Id]
    #[Column(name: "order_id", type: Types::INTEGER), GeneratedValue("AUTO")]
    private ?int $orderId = null;

    // FORMAT: ORD-[ORDERID]-[CLIENTID]-[RANDOM4]
    // EX: ORD-1-1-U1AS
    // Should not be null, but has to because it is generated using PK ids, 
    // and those are only generated after the Order is inserted into the
    // database.  
    #[Column(name: "reference_number", type: Types::STRING)]
    private ?string $referenceNumber = null;

    #[Column(name: "price", type: Types::DECIMAL, precision: 10, scale: 2)]
    private string $price;

    #[Column(name: "`status`", enumType: Status::class, nullable: true)]
    private Status $status;

    #[Column(name: "invoice_number", type: Types::STRING, nullable: true)]
    private string $invoiceNumber;

    #[Column(name: "creation_date", type: Types::DATETIME_MUTABLE, generated: "ALWAYS")]
    private ?DateTime $creationDate = null;

    #[Column(name: "fabrication_start_date", type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTime $fabricationStartDate;

    #[Column(name: "estimated_install_date", type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTime $estimatedInstallDate;

    #[Column(name: "order_completed_date", type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTime $orderCompletedDate;

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
        $this->product = $product;
    }

    public function assignReferenceNumber(): void {
        $randomChars = strtoupper(substr(md5(random_bytes(15)), 0, 5));
        $this->referenceNumber = "ORD-{$this->orderId}-{$this->client->getClientId()}-{$randomChars}";
    }

    public function getOrderId(): ?int {
        return $this->orderId;
    }

    public function getReferenceNumber(): string {
        return $this->referenceNumber;
    }

    public function getPrice(): string {
        return $this->price;
    }

    public function setPrice(string $price): void {
        if (!Utils::validatePositiveAmount($price)) {
            throw new InvalidArgumentException("The price must be greater than zero!");
        }
        $this->price = $price;
    }

    public function getStatus(): Status {
        return $this->status;
    }

    public function setStatus(Status $status): void {
        $this->status = $status;
    }

    public function getInvoiceNumber(): string {
        return $this->invoiceNumber;
    }

    public function setInvoiceNumber(string $invoiceNumber): void {
        if (!Utils::validateInvoiceNumber($invoiceNumber)) {
            throw new InvalidArgumentException("The invoice number is invalid!");
        }
        $this->invoiceNumber = $invoiceNumber;
    }

    public function getCreationDate(): ?DateTime {
        return $this->creationDate;
    }

    public function getFabricationStartDate(): ?DateTime {
        return $this->fabricationStartDate;
    }

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

    public function getEstimatedInstallDate(): ?DateTime {
        return $this->estimatedInstallDate;
    }

    public function setEstimatedInstallDate(?DateTime $date) {
        if ($date == null) {
            $this->estimatedInstallDate = null;
            return;
        }
        if (!Utils::validateDateInFuture($date)) {
            throw new InvalidArgumentException("The estimated installation date must be in the future!");
        }
        $this->estimatedInstallDate = $date;
    }

    public function getOrderCompletedDate(): ?DateTime {
        return $this->orderCompletedDate;
    }

    public function setOrderCompletedDate(?DateTime $date) {
        if ($date == null) {
            $this->orderCompletedDate = null;
            return;
        }
        if (!Utils::validateDateInPastOrNow($date)) {
            throw new InvalidArgumentException("The order completion date must be in the past or present!");
        }
        $this->orderCompletedDate = $date;
    }

    public function getClient(): Client {
        return $this->client;
    }

    public function getMeasuredBy(): Employee {
        return $this->measuredBy;
    }

    public function getPayments(): Collection {
        return $this->payments;
    }

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
    case MEASURING = "MEASURING";
    case ORDERING_MATERIAL = "ORDERING_MATERIAL";
    case FABRICATING = "FABRICATING";
    case READY_TO_HANDOVER = "READY_TO_HANDOVER";
    case INSTALLED = "INSTALLED";
    case PICKED_UP = "PICKED_UP";
}
