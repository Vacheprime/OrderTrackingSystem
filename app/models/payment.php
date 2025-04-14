<?php

declare(strict_types = 1);

namespace app\models;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\GeneratedValue;
use Decimal\Decimal;
use OTPHP\TOTP;

use app\core\utils\Utils;
use DateTime;
use Doctrine\DBAL\Types\DecimalType;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use InvalidArgumentException;

require_once(dirname(__DIR__)."/vendor/autoload.php");
require_once(dirname(__DIR__)."/core/utils/utils.php");
require_once("order.php");

#[Entity]
#[Table(name: "payment")]
class Payment {
    #[Id]
    #[Column(name: "payment_id", type: Types::INTEGER), GeneratedValue("AUTO")]
    private ?int $paymentId = null;

    #[Column(name: "amount", type: Types::DECIMAL, precision: 10, scale: 2)]
    private Decimal $amount;

    #[Column(name: "`type`", type: Types::STRING)]
    private string $type;

    #[Column(name: "method", type: Types::STRING)]
    private string $method;

    #[Column(name: "payment_date", type: Types::DATE_MUTABLE)]
    private DateTime $paymentDate;

    #[ManyToOne(targetEntity: Order::class, inversedBy: "payments")]
    #[JoinColumn(name: "order_id", referencedColumnName: "order__id")]
    private Order $order;
}