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
use InvalidArgumentException;

require_once(dirname(__DIR__)."/core/utils/utils.php");

#[Entity]
#[Table("address")]
class Address {
    #[Id]
    #[Column(name: "address_id", type: Types::INTEGER), GeneratedValue("AUTO")]
    private ?int $addressId = null;

    #[Column(name: "street_name", type: Types::STRING)]
    private string $streetName;

    #[Column(name: "appartment_number", type: Types::STRING)]
    private ?string $appartmentNumber;

    #[Column(name: "postal_code", type: Types::STRING)]
    private string $postalCode;

    #[Column(name: "area", type: Types::STRING)]
    private string $area;

    public function __construct(string $streetName, ?string $aptNumber, string $postalCode, string $area) {
        $this->setStreetName($streetName);
        $this->setAppartmentNumber($aptNumber);
        $this->setPostalCode($postalCode);
        $this->setArea($area);
    }

    public function getAddressId(): ?int {
        return $this->addressId;
    }

    public function getStreetName(): string {
        return $this->streetName;
    }

    public function setStreetName(string $streetName): void {
        if (!Utils::validateStreetName($streetName)) {
            throw new InvalidArgumentException("The street name is invalid!");
        }
        $this->streetName = $streetName;
    }

    public function getAppartmentNumber(): ?string {
        return $this->appartmentNumber;
    }

    public function setAppartmentNumber(?string $aptNumber): void {
        if ($aptNumber == null) {
            $this->appartmentNumber = null;
            return;
        }
        if (!Utils::validateAptNumber($aptNumber)) {
            throw new InvalidArgumentException("The appartment number is invalid!");
        }
        $this->appartmentNumber = $aptNumber;
    }

    public function getPostalCode(): string {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): void {
        if (!Utils::validatePostalCode($postalCode)) {
            throw new InvalidArgumentException("The postal code is invalid!");
        }
        $this->postalCode = $postalCode;
    }

    public function getArea(): string {
        return $this->area;
    }

    public function setArea(string $area): void {
        if (!Utils::validateArea($area)) {
            throw new InvalidArgumentException("The area is invalid!");
        }
        $this->area = $area;
    }
}