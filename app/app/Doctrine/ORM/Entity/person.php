<?php

declare(strict_types = 1);

namespace app\Doctrine\ORM\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\DBAL\Types\Types;

use app\Utils\Utils;
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
        if (!Utils::validateName($firstName)) {
            throw new InvalidArgumentException("The first name is invalid!");
        }
        $this->firstName = $firstName;
    }

    public function getLastName(): string {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void {
        if (!Utils::validateName($lastName)) {
            throw new InvalidArgumentException("The last name is invalid!");
        }
        $this->lastName = $lastName;
    }

    public function getPhoneNumber(): string {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): void {
        if (!Utils::validatePhoneNumber($phoneNumber)) {
            throw new InvalidArgumentException("The phone number is invalid!");
        }
        $this->phoneNumber = $phoneNumber;
    }

    public function getAddress(): Address {
        return $this->address;
    }
}