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

    public function getAddressId(): int {
        return $this->addressId;
    }

    public function getStreetName(): string {
        return $this->streetName;
    }

    public function setStreetName(string $streetName): void {
        if (!Address::validateStreetName($streetName)) {
            throw new InvalidArgumentException("The street name is invalid!");
        }
        $this->streetName = $streetName;
    }

    public function getAppartmentNumber(): ?string {
        return $this->appartmentNumber;
    }

    public function setAppartmentNumber(string $aptNumber): void {
        if (!Address::validateAptNumber($aptNumber)) {
            throw new InvalidArgumentException("The appartment number is invalid!");
        }
        $this->appartmentNumber = $aptNumber;
    }

    public function getPostalCode(): string {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): void {
        if (!Address::validatePostalCode($postalCode)) {
            throw new InvalidArgumentException("The postal code is invalid!");
        }
        $this->postalCode = $postalCode;
    }

    public function getArea(): string {
        return $this->area;
    }

    public function setArea(string $area): void {
        if (!Address::validateArea($area)) {
            throw new InvalidArgumentException("The area is invalid!");
        }
        $this->area = $area;
    }

    /**
     * Checks whether a street name is of proper format.
     * 
     * The format for a street name is a string ranging from 1 to 75 characters
     * inclusively. Accepted characters are any uppercase or lowercase letter in
     * any language, digits, spaces, periods, dashes, and single and double quotes.
     * The street name cannot start or end with whitespace characters.
     * 
     * @param string $streetName The street name to validate.
     * @return bool A boolean indicating whether the street name is valid.
     */
    public static function validateStreetName(string $streetName): bool {
        if (Utils::hasInvalidSpaces($streetName)) return false;
        return preg_match('/^[\p{L}\d \.\-\'\"]{1,75}$/u', $streetName) === 1;
    }

    /**
     * Checks whether an appartment number is of proper format.
     * 
     * The format for an appartment number is a string ranging from 1 to 15 characters
     * inclusively. Accepted characters are any uppercase or lowercase letter in any
     * language, digits, dashes, forward slashes, and periods. The appartment number
     * cannot start or end with whitespace characters.
     * 
     * 
     * @param string $aptNumber The appartment number to validate.
     * @return bool A boolean indicating whether the appartment number is valid.
     */
    public static function validateAptNumber(string $aptNumber): bool {
        if (Utils::hasInvalidSpaces($aptNumber)) return false;
        return preg_match('/^[\p{L}\d\-\/\.]{1,15}$/u', $aptNumber) === 1;
    }

    /**
     * Checks whether a postal code is of proper format.
     * 
     * The format for a postal code is defined on the Canada Post website:
     * https://www.canadapost-postescanada.ca/cpc/en/support/articles/addressing-guidelines/postal-codes.page
     * It is of the format: ZDL DLD
     * where L is one of the following letters: 
     * A B C E G H J K L M N P R S T V X Y
     * D is a digit, and L is an uppercase letter A-Z.
     * 
     * @param string $postalCode The postal code to validate.
     * @return bool A boolean indicating whether the postal code is valid.
     */
    public static function validatePostalCode(string $postalCode): bool {
        if (Utils::hasInvalidSpaces($postalCode)) return false;
        return preg_match('/^[ABCEGHJKLMNPRSTVXY]\d[A-Z] \d[A-Z]\d$/', $postalCode) === 1;
    }

    /**
     * Checks whether an area is of proper format.
     * 
     * The format of an area is a string ranging from 1 to 50 characters
     * inclusively. Accepted characters are any uppercase or lowercase letter 
     * from any language, dashes, spaces, periods, and single and double quotes. 
     * The area cannot start or end with whitespace characters.
     * 
     * @param string $area The area to validate.
     * @return bool A boolean indicating whether the area is valid.
     */
    public static function validateArea(string $area): bool {
        if (Utils::hasInvalidSpaces($area)) return false;
        return preg_match('/^[\p{L}\-\.\'\" ]{1,50}$/u', $area) === 1;
    }
}