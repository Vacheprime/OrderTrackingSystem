<?php

declare(strict_types = 1);

namespace app\Doctrine\ORM\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\DBAL\Types\Types;

use app\Utils\Utils;
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
    private string $productDescription;

    #[Column(name:"sink_type", type: Types::STRING, nullable: true)]
    private ?string $sinkType;

    #[Column(name:"product_square_footage", type: Types::DECIMAL, precision:10, scale:2, nullable: true)]
    private ?string $productSquareFootage;

    #[Column(name:"product_notes", type: Types::STRING, nullable: true)]
    private ?string $productNotes;

    public function __construct(
        Order $orderId,
        ?string $materialName,
        bool $isMaterialAvailable,
        ?int $slabHeight,
        ?int $slabWidth,
        ?int $slabThickness,
        ?string $planImagePath,
        string $productDescription,
        ?string $sinkType,
        ?string $productSquareFootage,
        ?string $productNotes
    ) {
        $this->orderId = $orderId;
        $this->setMaterialName($materialName);
        $this->setIsMaterialAvailable($isMaterialAvailable);
        $this->setSlabHeight($slabHeight);
        $this->setSlabWidth($slabWidth);
        $this->setSlabThickness($slabThickness);
        $this->setPlanImagePath($planImagePath);
        $this->setProductDescription($productDescription);
        $this->setSinkType($sinkType);
        $this->setProductSquareFootage($productSquareFootage);
        $this->setProductNotes($productNotes);
    }

    public function getOrderId():int {
        return $this->orderId->getOrderId();
    }

    public function getMaterialName():string {
        return $this->materialName;
    }

    public function setMaterialName(?string $materialName) {
        if ($materialName == null) {
            $this->materialName = null;
            return;
        }
        if (!Utils::validateMaterial($materialName)) {
            throw new InvalidArgumentException("The material name is invalid!");
        }
        $this->materialName = $materialName;
    }

    public function getIsMaterialAvailable(): bool {
        return $this->isMaterialAvailable;
    }

    public function setIsMaterialAvailable(bool $isMaterialAvailable) {
        $this->isMaterialAvailable = $isMaterialAvailable;
    }

    public function getSlabHeight():int {
        return $this->slabHeight;
    }

    public function setSlabHeight(?int $slabHeight){
        if ($slabHeight == null) {
            $this->slabHeight = $slabHeight;
            return;
        }
        if (!Utils::validateSlab($slabHeight)) {
            throw new InvalidArgumentException("The slab height is invalid!");
        }
        $this->slabHeight = $slabHeight;
    }

    public function getSlabWidth(): int {
        return $this->slabWidth;
    }

    public function setSlabWidth(?int $slabWidth){
        if ($slabWidth == null) {
            $this->slabWidth = $slabWidth;
            return;
        }
        if (!Utils::validateSlab($slabWidth)) {
            throw new InvalidArgumentException("The slab height is invalid!");
        }
        $this->slabWidth = $slabWidth;
    }

    public function getSlabThickness():int {
        return $this->slabThickness;
    }

    public function setSlabThickness(?int $slabThickness) {
        if ($slabThickness == null) {
            $this->slabThickness = null;
            return;
        }
        if (!Utils::validateSlabThickness($slabThickness)) {
            throw new InvalidArgumentException("The slab thickness is invalid!");
        }
        $this->slabThickness = $slabThickness;
    }

    public function getPlanImagePath():string {
        return $this->planImagePath;
    }

    public function setPlanImagePath(?string $imagePath) {
        if ($imagePath == null) {
            $this->planImagePath = $imagePath;
            return;
        }
        if (!Utils::validateImagePath($imagePath)) {
            throw new InvalidArgumentException("The image path is invalid!");
        }
        $this->planImagePath = $imagePath;
    }

    public function getProductDescription():string {
        return $this->productDescription;
    }

    public function setProductDescription(string $productDescription) {
        $this->productDescription = $productDescription;
    }

    public function getSinkType():string {
        return $this->sinkType;
    }

    public function setSinkType(?string $sinkType) {
        if ($sinkType == null) {
            $this->sinkType = null;
            return;
        }
        if (!Utils::validateMaterial($sinkType)) {
            throw new InvalidArgumentException("The sink type is invalid!");
        }
        $this->sinkType = $sinkType;
    }

    public function getProductSquareFootage():string {
        return $this->productSquareFootage;
    }

    public function setProductSquareFootage(?string $productSquareFootage) {
        if ($productSquareFootage == null) {
            $this->productSquareFootage = null;
            return;
        }
        if (!Utils::validateProductSquareFootage($productSquareFootage)) {
            throw new InvalidArgumentException("The product square footage is invalid!");
        }
        $this->productSquareFootage = $productSquareFootage;
    }

    public function getProductNotes():string {
        return $this->productNotes;
    }

    public function setProductNotes(?string $productNotes) {
        $this->productNotes = $productNotes;
    }
}