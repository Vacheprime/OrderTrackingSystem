<?php

declare(strict_types = 1);

namespace app\Doctrine\ORM\Entity;

use app\Doctrine\ORM\Entity\Order;
use app\Doctrine\ORM\Entity\Employee;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\GeneratedValue;

use DateTime;
use app\Utils\Utils;
use InvalidArgumentException;

require_once(dirname(dirname(dirname(__DIR__)))."/Utils/utils.php");

#[Entity]
#[Table("activity_history")]
class ActivityHistory {
    #[Id]
    #[Column(name:'activity_history_id', type: Types::INTEGER, GeneratedValue("AUTO"))]
    private ?int $activityHistoryId = null;

    #[Column(name:'activity_type', type: Types::STRING)]
    private string $activityType;

    #[Column(name:'activity_date', type: Types::DATE_MUTABLE)]
    private DateTime $activityDate;

    #[ManyToOne(targetEntity: Order::class, cascade: ["persist"])]
    #[JoinColumn(name: "order_id", referencedColumnName: "order_id")]
    private Order $order;

    #[ManyToOne(targetEntity: Employee::class, cascade: ["persist"])]
    #[JoinColumn(name: "employee_id", referencedColumnName: "employee_id")]
    private Employee $employee;

    public function __construct() {

    }
}