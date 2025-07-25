<?php

declare(strict_types = 1);


namespace app\Doctrine\ORM\Entity;

use app\Doctrine\ORM\Entity\Order;
use app\Doctrine\ORM\Entity\Employee;
use app\Doctrine\ORM\Repository\ActivityRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

use DateTime;

#[Entity(repositoryClass: ActivityRepository::class)]
#[Table("activity")]
class Activity {
    #[Id]
    #[Column(name:'activity_id', type: Types::INTEGER), GeneratedValue("AUTO")]
    private ?int $activityId = null;

    #[Column(name:'activity_type', enumType: ActivityType::class)]
    private ActivityType $activityType;

    #[Column(name:'log_date', type: Types::DATETIME_MUTABLE)]
    private DateTime $logDate;

    #[ManyToOne(targetEntity: Order::class, cascade: ["persist"])]
    #[JoinColumn(name: "order_id", referencedColumnName: "order_id")]
    private Order $order;

    #[ManyToOne(targetEntity: Employee::class, cascade: ["persist"])]
    #[JoinColumn(name: "employee_id", referencedColumnName: "employee_id")]
    private Employee $employee;

    public function __construct(ActivityType $activityType, Order $order, Employee $employee) {
        $this->setActivityType($activityType);
        $this->logDate = new DateTime();
        $this->order = $order;
        $this->employee = $employee;
    }

    public function getActivityId(): ?int {
        return $this->activityId;
    }

    public function getActivityType(): ActivityType {
        return $this->activityType;
    }

    public function setActivityType(ActivityType $activityType): void {
        $this->activityType = $activityType;
    }

    public function getLogDate(): DateTime {
        return $this->logDate;
    }

    public function setLogDate(DateTime $logDate): void {
        $this->logDate = $logDate;
    }

    public function getOrder(): Order {
        return $this->order;
    }

    public function getEmployee(): Employee {
        return $this->employee;
    }
}