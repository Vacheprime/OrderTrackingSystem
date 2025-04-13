<?php

declare(strict_types = 1);

namespace models;

use core\utils\Utils;

require_once(dirname(__DIR__)."/core/utils/utils.php");

class Address {
    private int $addressId;
    private string $streetName;
    private ?string $appartmentNumber;
    private string $postalCode;
    private string $area;

    public function getAddressId(): int {
        return $this->addressId;
    }

    public function getStreetName(): string {
        return $this->streetName;
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