<?php

declare(strict_types = 1);


namespace app\models;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\GeneratedValue;
use OTPHP\TOTP;

use app\core\utils\Utils;
use DateTime;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use InvalidArgumentException;

require_once(dirname(__DIR__)."/vendor/autoload.php");
require_once(dirname(__DIR__)."/core/utils/utils.php");
require_once("address.php");
require_once("person.php");

#[Entity]
#[Table("`order`")]
class Order {
    #[Id]
    #[Column(name: "order_id", type: Types::INTEGER), GeneratedValue("AUTO")]
    private ?int $orderId = null;

    #[Column(name: "reference_number", type: Types::STRING)]
    private string $referenceNumber;

    #[Column(name: "is_plan_ready", type: Types::BOOLEAN)]
    private bool $isPlanReady;

    #[Column(name: "is_in_fabrication", type: Types::BOOLEAN)]
    private bool $isInFabrication;

    #[Column(name: "is_completed", type: Types::BOOLEAN)]
    private bool $isCompleted;

    #[Column(name: "fabrication_start_date", type: Types::DATE_MUTABLE, nullable: true)]
    private DateTime $fabricationStartDate;

    // MISSING PRICE AND TAXES. USE ACCURATE DATA TYPES

    #[Column(name: "estimated_install_date", type: Types::DATE_MUTABLE, nullable: true)]
    private DateTime $estimatedInstallDate;

    #[Column(name: "order_completed_date", type: Types::DATE_MUTABLE, nullable: true)]
    private DateTime $orderCompletedDate;

    #[Column(name: "invoice_number", type: Types::STRING, nullable: true)]
    private string $invoiceNumber;

    #[Column(name: "`status`", enumType: Status::class, nullable: true)]
    private Status $status;

    #[ManyToOne(targetEntity: Client::class)]
    #[JoinColumn(name: "`client_id`", referencedColumnName: "`client_id`")]
    private Client $client;

    #[ManyToOne(targetEntity: Employee::class)]
    #[JoinColumn(name: "measured_by", referencedColumnName: "employee_id")]
    private Employee $measuredBy;
}

enum Status: string {
    case CONFIRMED_MS_NOT_READY = "CONFIRMED_MS_NOT_READY";
    case READY_FOR_MEASUREMENTS = "READY_FOR_MEASUREMENTS";
    case CONFIRMED_MS_READY = "CONFIRMED_MS_READY";
    case INSTALLED = "INSTALLED";
    case PICKED_UP = "PICKED_UP";
}