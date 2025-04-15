<?php

declare(strict_types = 1);

namespace app\models;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\GeneratedValue;

use app\core\utils\Utils;
use DateTime;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use InvalidArgumentException;

require_once(dirname(__DIR__)."/vendor/autoload.php");
require_once(dirname(__DIR__)."/mysql/orm_config/doctrine_config.php");
require_once(dirname(__DIR__)."/core/utils/utils.php");
require_once("order.php");

#[Entity]
#[Table(name: "payment")]
class Payment {
    #[Id]
    #[Column(name: "payment_id", type: Types::INTEGER), GeneratedValue("AUTO")]
    private ?int $paymentId = null;

    // For accurate decimal arithmetic, the database value is converted to string.
    #[Column(name: "amount", type: Types::DECIMAL, precision: 10, scale: 2)]
    private string $amount;

    #[Column(name: "`type`", enumType: PaymentType::class)]
    private PaymentType $type;

    #[Column(name: "method", type: Types::STRING)]
    private string $method;

    #[Column(name: "payment_date", type: Types::DATE_MUTABLE)]
    private DateTime $paymentDate;

    #[ManyToOne(targetEntity: Order::class, inversedBy: "payments", cascade: ["persist"])]
    #[JoinColumn(name: "order_id", referencedColumnName: "order_id")]
    private Order $order;

    public function __construct(
        string $amount,
        PaymentType $type,
        string $method,
        DateTime $paymentDate,
        Order $order
    )
    {
        $this->setAmount($amount);
        $this->setType($type);
        $this->setMethod($method);
        $this->setPaymentDate($paymentDate);
        $this->order = $order;
    }

    public function getPaymentId(): ?int {
        return $this->paymentId;
    }

    public function getAmount(): string {
        return $this->amount;
    }

    public function setAmount(string $amount): void {
        if (!Utils::validatePositiveAmount($amount)) {
            throw new InvalidArgumentException("The payment amount is invalid!");
        }
        $this->amount = $amount;
    }

    public function getType(): PaymentType {
        return $this->type;
    }

    public function setType(PaymentType $type): void {
        $this->type = $type;
    }

    public function getMethod(): string {
        return $this->method;
    }

    public function setMethod(string $method): void {
        if (!Utils::validatePaymentMethod($method)) {
            throw new InvalidArgumentException("The payment method is invalid!");
        }
        $this->method = $method;
    }

    public function getPaymentDate(): DateTime {
        return $this->paymentDate;
    }

    public function setPaymentDate(DateTime $paymentDate): void {
        if (!Utils::validateDateInPastOrNow($paymentDate)) {
            throw new InvalidArgumentException("The payment date is invalid!");
        }
        $this->paymentDate = $paymentDate;
    }

    public function getOrder(): Order {
        return $this->order;
    }
}

enum PaymentType: string {
    case DEPOSIT = "DEPOSIT";
    case INSTALLMENT = "INSTALLMENT";
}
