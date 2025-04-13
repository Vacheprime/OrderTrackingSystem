<?php

declare(strict_types = 1);

namespace app\models;

use Doctrine\ORM\Mapping\Column;
use Doctrine\DBAL\Types\Types;

use app\core\utils\Utils;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping\OneToOne;
use InvalidArgumentException;

require_once(dirname(__DIR__)."/core/utils/utils.php");
require_once("address.php");

#[MappedSuperclass]
abstract class Person {

    #[Column(name: "first_name", type: Types::STRING)]
    protected string $firstName;
    
    #[Column(name: "last_name", type: Types::STRING)]
    protected string $lastName;

    #[Column(name: "phone_number", type: Types::STRING)]
    protected string $phoneNumber;

    #[OneToOne(targetEntity: Address::class, cascade: ["persist", "remove"])]
    #[JoinColumn(name: "address_id", referencedColumnName: "address_id")]
    protected Address $address;

    public function __construct(string $firstName, string $lastName, string $phoneNumber, Address $address) {
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->setPhoneNumber($phoneNumber);
        $this->address = $address;
    }

    public function getFirstName(): string {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void {
        if (!Person::validateName($firstName)) {
            throw new InvalidArgumentException("The first name is invalid!");
        }
        $this->firstName = $firstName;
    }

    public function getLastName(): string {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void {
        if (!Person::validateName($lastName)) {
            throw new InvalidArgumentException("The last name is invalid!");
        }
        $this->lastName = $lastName;
    }

    public function getPhoneNumber(): string {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): void {
        if (!Person::validatePhoneNumber($phoneNumber)) {
            throw new InvalidArgumentException("The phone number is invalid!");
        }
        $this->phoneNumber = $phoneNumber;
    }

    public function getAddress(): Address {
        return $this->address;
    }

    /**
     * Checks whether a phone number is of valid format.
     * 
     * The format for a phone number is a string of 17 characters.
     * It has the format +D (DDD) DDD-DDDD where D is a digit.
     * 
     * @param string $phoneNumber The phone number to validate.
     * @return bool A boolean indicating whether the phone number is valid.
     */
    public static function validatePhoneNumber(string $phoneNumber): bool {
        return preg_match('/^\+\d \(\d{3}\) \d{3}-\d{4}$/', $phoneNumber) === 1;
    }

    /**
     * Checks whether a name, first or last, is of valid format.
     * 
     * The format for a name is a string ranging from 1 to 50 characters
     * inclusively. Accepted characters are any uppercase
     * or lowercase letter of any language, apostrophes, dashes, and spaces.
     * The name cannot start or end with whitespace characters.
     * 
     * @param string $name The name to validate.
     * @return bool A boolean indicating whether the name is valid.
     */
    public static function validateName(string $name): bool {
        if (Utils::hasInvalidSpaces($name)) return false;
        return preg_match('/[\p{L}\'\- ]{1,50}/u', $name) === 1;
    }
}