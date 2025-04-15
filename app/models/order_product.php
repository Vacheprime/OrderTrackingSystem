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
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use InvalidArgumentException;

require_once(dirname(__DIR__)."/core/utils/utils.php");
require_once("order.php");

#[Entity]
#[Table("order_product")]

class OrderProduct {
    #[Id]
    #[OneToOne(targetEntity: Order::class)]
    #[JoinColumn(name:"order_id", referencedColumnName: "order_id")]
    private Order $orderId;

    #[Column(name:"material_name", type: Types::STRING, nullable: true)]
    private ?string $materialName;

    #[Column(name:"is_material_available", type: Types::BOOLEAN)]
    private bool $isMaterialAvailable;

    #[Column(name:"slab_height", type: Types::INTEGER, nullable: true)]
    private ?int $slabHeight;

    #[Column(name:"slab_width", type: Types::INTEGER, nullable: true)]
    private ?int $slabWidth;
    
    #[Column(name:"slab_thickness", type: Types::INTEGER, nullable: true)]
    private ?int $slabThickness;

    #[Column(name:"plan_image_path", type: Types::STRING, nullable: true)]
    private ?string $planImagePath;

    #[Column(name:"product_description", type: Types::STRING)]
    private ?string $productDescription;

    #[Column(name:"sink_type", type: Types::STRING, nullable: true)]
    private ?string $sinkType;

    #[Column(name:"product_square_footage", type: Types::DECIMAL, precision:10, scale:2, nullable: true)]
    private ?string $productSquareFootage;

    #[Column(name:"product_notes", type: Types::STRING, nullable: true)]
    private ?string $productNotes;
}