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
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

use DateTime;

require_once(dirname(dirname(dirname(__DIR__)))."/Utils/utils.php");

#[Entity]
#[Table("activity_history")]
class ActivityHistory {
    #[Id]
    #[Column(name:'activity_history_id', type: Types::INTEGER), GeneratedValue("AUTO")]
    private ?int $activityHistoryId = null;

    #[Column(name:'activity_type', enumType: Status::class)]
    private Activity $activityType;

    #[Column(name:'activity_date', type: Types::STRING)]
    private STRING $activityDate;

    #[ManyToOne(targetEntity: Order::class, cascade: ["persist"])]
    #[JoinColumn(name: "order_id", referencedColumnName: "order_id")]
    private Order $order;

    #[ManyToOne(targetEntity: Employee::class, cascade: ["persist"])]
    #[JoinColumn(name: "employee_id", referencedColumnName: "employee_id")]
    private Employee $employee;

    public function __construct(Activity $activityType, Order $order, Employee $employee) {
        $this->setActivityType($activityType);
        $this->activityDate = (new DateTime())->format('Y-m-d H:i:s');
        $this->order = $order;
        $this->employee = $employee;
    }

    public function getActivityHistoryId():int {
        return $this->activityHistoryId;
    }

    public function getActivityType():Activity {
        return $this->activityType;
    }

    public function setActivityType(Activity $activityType):void {
        $this->activityType = $activityType;
    }

    public function getActivityDate():string {
        return $this->activityDate;
    }

    public function getOrder():Order {
        return $this->order;
    }

    public function getEmployee():Employee {
        return $this->employee;
    }
}

enum Activity: string {
    case VIEWED = "VIEWED";
    case EDITED = "EDITED";
}