<?php

declare(strict_types = 1);


namespace app\Doctrine\ORM\Entity;

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
use InvalidArgumentException;

//require_once(dirname(__DIR__)."/vendor/autoload.php");
require_once(dirname(dirname(dirname(__DIR__)))."/Utils/utils.php");
require_once("address.php");
require_once("client.php");
require_once("employee.php");

#[Entity]
#[Table("`order`")]
class Order {
    #[Id]
    #[Column(name: "order_id", type: Types::INTEGER), GeneratedValue("AUTO")]
    private ?int $orderId = null;

    // FORMAT: ORD-[ORDERID]-[CLIENTID]-[RANDOM4]
    // EX: ORD-1-1-UHAS
    #[Column(name: "reference_number", type: Types::STRING)]
    private ?string $referenceNumber = null;

    #[Column(name: "is_plan_ready", type: Types::BOOLEAN)]
    private bool $isPlanReady;

    #[Column(name: "is_in_fabrication", type: Types::BOOLEAN)]
    private bool $isInFabrication;

    #[Column(name: "is_completed", type: Types::BOOLEAN)]
    private bool $isCompleted;

    #[Column(name: "fabrication_start_date", type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTime $fabricationStartDate;

    #[Column(name: "price", type: Types::DECIMAL, precision: 10, scale: 2)]
    private string $price;

    #[Column(name: "taxes", type: Types::DECIMAL, precision: 10, scale: 2)]
    private string $taxes;

    #[Column(name: "estimated_install_date", type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTime $estimatedInstallDate;

    #[Column(name: "order_completed_date", type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTime $orderCompletedDate;

    #[Column(name: "invoice_number", type: Types::STRING, nullable: true)]
    private string $invoiceNumber;

    #[Column(name: "`status`", enumType: Status::class, nullable: true)]
    private Status $status;

    #[ManyToOne(targetEntity: Client::class, cascade: ["persist"])]
    #[JoinColumn(name: "`client_id`", referencedColumnName: "`client_id`")]
    private Client $client;

    #[ManyToOne(targetEntity: Employee::class, cascade: ["persist"])]
    #[JoinColumn(name: "measured_by", referencedColumnName: "employee_id")]
    private Employee $measuredBy;

    #[OneToMany(targetEntity: Payment::class, mappedBy: "order", cascade: ["persist"])]
    private Collection $payments;

    public function __construct(
        bool $isPlanReady,
        bool $isInFabrication,
        bool $isCompleted,
        ?DateTime $fabricationStartDate,
        string $price,
        string $taxes,
        ?DateTime $estimatedInstallDate,
        ?DateTime $orderCompletedDate,
        string $invoiceNumber,
        Status $status,
        Client $client,
        Employee $measuredBy,
        Collection $payments
    )
    {
        $this->setIsPlanReady($isPlanReady);
        $this->setIsInFabrication($isInFabrication);
        $this->setIsCompleted($isCompleted);
        $this->setFabricationStartDate($fabricationStartDate);
        $this->setPrice($price);
        $this->setTaxes($taxes);
        $this->setEstimatedInstallDate($estimatedInstallDate);
        $this->setOrderCompletedDate($orderCompletedDate);
        $this->setInvoiceNumber($invoiceNumber);
        $this->setStatus($status);
        $this->client = $client;
        $this->measuredBy = $measuredBy;
        $this->payments = $payments;
    }

    public function generateReferenceNumber(): string {
        $randomChars = strtoupper(substr(md5(random_bytes(15)), 0, 5));
        return "ORD-{$this->orderId}-{$this->client->getClientId()}-{$randomChars}";
    }

    public function getOrderId(): ?int {
        return $this->orderId;
    }

    public function getReferenceNumber(): string {
        return $this->referenceNumber;
    }

    public function isPlanReady(): bool {
        return $this->isPlanReady;
    }

    public function setIsPlanReady(bool $isPlanReady): void {
        $this->isPlanReady = $isPlanReady;
    }

    public function isInFabrication(): bool {
        return $this->isInFabrication;
    }

    public function setIsInFabrication(bool $isInFabrication): void {
        $this->isInFabrication = $isInFabrication;
    }

    public function isCompleted(): bool {
        return $this->isCompleted;
    }

    public function setIsCompleted(bool $isCompleted): void {
        $this->isCompleted = $isCompleted;
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

    public function getPrice(): string {
        return $this->price;
    }

    public function setPrice(string $price): void {
        if (!Utils::validatePositiveAmount($price)) {
            throw new InvalidArgumentException("The price must be greater than zero!");
        }
        $this->price = $price;
    }

    public function getTaxes(): string {
        return $this->taxes;
    }

    public function setTaxes(string $taxes): void {
        if (!Utils::validatePositiveAmount($taxes)) {
            throw new InvalidArgumentException("The taxes must be greater than zero!");
        }
        $this->taxes = $taxes;
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

    public function getInvoiceNumber(): string {
        return $this->invoiceNumber;
    }

    public function setInvoiceNumber(string $invoiceNumber): void {
        if (!Utils::validateInvoiceNumber($invoiceNumber)) {
            throw new InvalidArgumentException("The invoice number is invalid!");
        }
        $this->invoiceNumber = $invoiceNumber;
    }

    public function getStatus(): Status {
        return $this->status;
    }

    public function setStatus(Status $status): void {
        $this->status = $status;
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
}

enum Status: string {
    case CONFIRMED_MS_NOT_READY = "CONFIRMED_MS_NOT_READY";
    case READY_FOR_MEASUREMENTS = "READY_FOR_MEASUREMENTS";
    case CONFIRMED_MS_READY = "CONFIRMED_MS_READY";
    case INSTALLED = "INSTALLED";
    case PICKED_UP = "PICKED_UP";
}
