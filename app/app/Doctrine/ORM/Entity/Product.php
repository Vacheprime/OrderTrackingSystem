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

require_once(dirname(dirname(dirname(__DIR__)))."/Utils/Utils.php");
require_once("Order.php");

#[Entity]
#[Table("product")]
class Product {
    #[Id]
    #[OneToOne(targetEntity: Order::class, inversedBy: "product", cascade: ["persist"])]
    #[JoinColumn(name: "order_id", referencedColumnName: "order_id")]
    private ?Order $order = null;

    #[Column(name:"material_name", type: Types::STRING, nullable: true)]
    private ?string $materialName;

    #[Column(name:"slab_height", type: Types::DECIMAL, precision: 6, scale: 2, nullable: true)]
    private ?string $slabHeight;

    #[Column(name:"slab_width", type: Types::DECIMAL, precision: 6, scale: 2, nullable: true)]
    private ?string $slabWidth;
    
    #[Column(name:"slab_thickness", type: Types::DECIMAL, precision: 4, scale: 2, nullable: true)]
    private ?string $slabThickness;

    #[Column(name:"slab_square_footage", type: Types::DECIMAL, precision: 8, scale: 2, nullable: true)]
    private ?string $slabSquareFootage;

    #[Column(name:"plan_image_path", type: Types::STRING, nullable: true)]
    private ?string $planImagePath;

    #[Column(name:"sink_type", type: Types::STRING, nullable: true)]
    private ?string $sinkType;

    #[Column(name:"product_description", type: Types::TEXT)]
    private string $productDescription;

    #[Column(name:"product_notes", type: Types::TEXT)]
    private string $productNotes;

    public function __construct(
        ?string $materialName,
        ?string $slabHeight,
        ?string $slabWidth,
        ?string $slabThickness,
        ?string $slabSquareFootage,
        ?string $planImagePath,
        ?string $sinkType,
        string $productDescription,
        string $productNotes
    ) {
        $this->setMaterialName($materialName);
        $this->setSlabHeight($slabHeight);
        $this->setSlabWidth($slabWidth);
        $this->setSlabThickness($slabThickness);
        $this->setSlabSquareFootage($slabSquareFootage);
        $this->setPlanImagePath($planImagePath);
        $this->setSinkType($sinkType);
        $this->setProductDescription($productDescription);
        $this->setProductNotes($productNotes);
    }

    public function getOrder(): ?Order {
        return $this->order;
    }

    /**
     * Necessary for order/product object creation.
     */
    public function setOrder(Order $order): void {
        $this->order = $order;
    }

    public function getMaterialName(): ?string {
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

    public function getSlabHeight(): ?string {
        return $this->slabHeight;
    }

    public function setSlabHeight(?string $slabHeight){
        if ($slabHeight == null) {
            $this->slabHeight = $slabHeight;
            return;
        }
        if (!Utils::validateSlabDimension($slabHeight)) {
            throw new InvalidArgumentException("The slab height is invalid!");
        }
        $this->slabHeight = $slabHeight;
    }

    public function getSlabWidth(): ?string {
        return $this->slabWidth;
    }

    public function setSlabWidth(?string $slabWidth){
        if ($slabWidth == null) {
            $this->slabWidth = $slabWidth;
            return;
        }
        if (!Utils::validateSlabDimension($slabWidth)) {
            throw new InvalidArgumentException("The slab height is invalid!");
        }
        $this->slabWidth = $slabWidth;
    }

    public function getSlabThickness(): ?string {
        return $this->slabThickness;
    }

    public function setSlabThickness(?string $slabThickness) {
        if ($slabThickness == null) {
            $this->slabThickness = null;
            return;
        }
        if (!Utils::validateSlabThickness($slabThickness)) {
            throw new InvalidArgumentException("The slab thickness is invalid!");
        }
        $this->slabThickness = $slabThickness;
    }

    public function getSlabSquareFootage(): ?string {
        return $this->slabSquareFootage;
    }

    public function setSlabSquareFootage(?string $slabSquareFootage) {
        if ($slabSquareFootage == null) {
            $this->slabSquareFootage = null;
            return;
        }
        if (!Utils::validateSlabSquareFootage($slabSquareFootage)) {
            throw new InvalidArgumentException("The product square footage is invalid!");
        }
        $this->slabSquareFootage = $slabSquareFootage;
    }

    public function getPlanImagePath(): ?string {
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

    public function getSinkType(): ?string {
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

    public function getProductDescription(): string {
        return $this->productDescription;
    }

    public function setProductDescription(string $productDescription) {
        $this->productDescription = $productDescription;
    }

    public function getProductNotes(): string {
        return $this->productNotes;
    }

    public function setProductNotes(string $productNotes) {
        $this->productNotes = $productNotes;
    }
}