<?php

declare(strict_types = 1);

namespace app\Doctrine\ORM\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Embeddable;
use OTPHP\TOTP;

use app\Utils\Utils;
use InvalidArgumentException;

require_once(dirname(dirname(dirname(__DIR__)))."/Utils/Utils.php");
require_once("Address.php");
require_once("Person.php");

#[Entity]
#[Table(name: "employee")]
class Employee extends Person {
    #[Id]
    #[Column(name: "employee_id", type: Types::INTEGER), GeneratedValue("AUTO")]
    private ?int $employeeId = null;

    #[Column(name: "initials", type: Types::STRING)]
    private string $initials;
 
    #[Column(name: "position", type: Types::STRING)]
    private string $position;

    #[Column(name: "email", type: Types::STRING)]
    private string $email;

    #[Column(name: "is_admin", type: Types::BOOLEAN)]
    private bool $isAdmin;

    #[Column(name: "has_set_up_2fa", type: Types::BOOLEAN)]
    private bool $hasSetUp2fa = false;

    #[Column(name: "password_hash", type: Types::STRING)]
    private string $passwordHash;

    #[Column(name: "secret", type: Types::STRING)]
    private string $secret;

    public function __construct(
        string $firstName,
        string $lastName,
        string $phoneNumber,
        Address $address,
        string $initials,
        string $position,
        string $email,
        bool $isAdmin,
        string $password
    ) {
        // Use setters because they include input validation.
        parent::__construct($firstName, $lastName, $phoneNumber, $address);
        $this->setInitials($initials);
        $this->setPosition($position);
        $this->setEmail($email);
        $this->setIsAdmin($isAdmin);
        $this->setPassword($password);
        $this->secret = $this->generateTOTPSecret();
    }

    private function generateTOTPSecret(): string {
        // Create the TOTP object 
        $totp = TOTP::generate();
        // Return the TOTP secret
        return $totp->getSecret();
    }

    public function getEmployeeId(): ?int {
        return $this->employeeId;
    }

    public function getInitials(): string {
        return $this->initials;
    }

    public function setInitials(string $initials): void {
        if (!Utils::validateInitials($initials)) {
            throw new InvalidArgumentException("The initials are inbalid!");
        }
        $this->initials = $initials;
    }

    public function getPosition(): string {
        return $this->position;
    }

    public function setPosition(string $position): void {
        if (!Utils::validatePosition($position)) {
            throw new InvalidArgumentException("The position is invalid!");
        }
        $this->position = $position;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        if (!Utils::validateEmail($email)) {
            throw new InvalidArgumentException("The email is invalid!");
        }
        $this->email = $email;
    }

    public function isAdmin(): bool {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): void {
        $this->isAdmin = $isAdmin;
    }

    public function hasSetUp2fa(): bool {
        return $this->hasSetUp2fa;
    }

    public function setHasSetUp2fa(bool $hasSetUp2fa) {
        $this->hasSetUp2fa = $hasSetUp2fa;
    }

    public function getPasswordHash(): string {
        return $this->passwordHash;
    }

    public function setPassword(string $password): void {
        if (!Utils::validatePassword($password)) {
            throw new InvalidArgumentException("The password is invalid!");
        }
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }

    public function getSecret(): string {
        return $this->secret;
    }
}


#[Embeddable]
class Account {
    #[Column(type: Types::STRING)]
    private string $email;

    #[Column(type: Types::STRING)]
    private string $passwordHash;

    #[Column(type: Types::BOOLEAN)]
    private bool $isAdmin;

    #[Column(type: Types::BOOLEAN)]
    private bool $hasSetUp2fa;

    #[Column(type: Types::STRING)]
    private string $secret;


    public function __construct(string $email, string $password, bool $isAdmin, bool $hasSetUp2fa) {
        $this->setEmail($email);
        $this->setIsAdmin($isAdmin);
        $this->setPassword($password);
        $this->setHasSetUp2fa($hasSetUp2fa);
        $this->secret = $this->generateTOTPSecret();
    }

    public function getSecret(): string {
        return $this->secret;
    }

    private function generateTOTPSecret(): string {
        // Create the TOTP object 
        $totp = TOTP::generate();
        // Return the TOTP secret
        return $totp->getSecret();
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        if (!Utils::validateEmail($email)) {
            throw new InvalidArgumentException("The email is invalid!");
        }
        $this->email = $email;
    }

    public function isAdmin(): bool {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): void {
        $this->isAdmin = $isAdmin;
    }

    public function hasSetUp2fa(): bool {
        return $this->hasSetUp2fa;
    }

    public function setHasSetUp2fa(bool $hasSetUp2fa) {
        $this->hasSetUp2fa = $hasSetUp2fa;
    }

    public function getPasswordHash(): string {
        return $this->passwordHash;
    }

    public function setPassword(string $password): void {
        if (!Utils::validatePassword($password)) {
            throw new InvalidArgumentException("The password is invalid!");
        }
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }
}