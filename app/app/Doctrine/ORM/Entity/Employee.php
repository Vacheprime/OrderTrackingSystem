<?php

declare(strict_types = 1);

namespace app\Doctrine\ORM\Entity;

use app\Doctrine\ORM\Repository\EmployeeRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Embeddable;
use Doctrine\ORM\Mapping\Embedded;
use OTPHP\TOTP;
use Illuminate\Contracts\Auth\Authenticatable;

use app\Utils\Utils;
use InvalidArgumentException;

require_once(dirname(dirname(dirname(__DIR__)))."/Utils/Utils.php");
require_once("Address.php");
require_once("Person.php");

#[Entity(repositoryClass: EmployeeRepository::class)]
#[Table(name: "employee")]
class Employee extends Person implements Authenticatable {
    #[Id]
    #[Column(name: "employee_id", type: Types::INTEGER), GeneratedValue("AUTO")]
    private ?int $employeeId = null;

    #[Column(name: "initials", type: Types::STRING)]
    private string $initials;
 
    #[Column(name: "position", type: Types::STRING)]
    private string $position;

    #[Embedded(class: Account::class, columnPrefix: false)]
    private Account $account;

    public function __construct(
        string $firstName,
        string $lastName,
        string $phoneNumber,
        Address $address,
        string $initials,
        string $position,
        Account $account
    ) {
        // Use setters because they include input validation.
        parent::__construct($firstName, $lastName, $phoneNumber, $address);
        $this->setInitials($initials);
        $this->setPosition($position);
        $this->account = $account;
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

    public function getAccount(): Account {
        return $this->account;
    }

    /**
     * Get the name of the column in the employee table that corresponds to
     * the primary key column. 
     * 
     * Implementation of the Authenticatable interface.
     * 
     * @return string The column name of the primary key.
     */
    public function getAuthIdentifierName()
    {
        return "employee_id";
    }

    /**
     * Get the primary key of the employee.
     * 
     * Implementation of the Authenticatable interface.
     * 
     * @return ?int The primary key of the employee.
     */
    public function getAuthIdentifier()
    {
        return $this->employeeId;
    }

    /**
     * Get the name of the column in the employee table that corresponds to
     * the password hash.
     */
    public function getAuthPasswordName()
    {
        return "password_hash";
    }

    /**
     * Get the password hash of the employee.
     * 
     * Implementation of the Authenticatable interface.
     * 
     * @return string The password hash of the employee
     */
    public function getAuthPassword()
    {
        return $this->account->getPasswordHash();
    }

    /**
     * Not implemented.
     */
    public function getRememberTokenName()
    {
        return null;
    }

    /**
     * Not implemented.
     */
    public function getRememberToken()
    {
        return null;        
    }

    /**
     * Not implemented.
     */
    public function setRememberToken($value) {}
}


#[Embeddable]
class Account {
    #[Column(name: "email", type: Types::STRING)]
    private string $email;

    #[Column(name: "password_hash", type: Types::STRING)]
    private string $passwordHash;

    #[Column(name: "is_admin", type: Types::BOOLEAN)]
    private bool $isAdmin;

    #[Column(name: "has_set_up_2fa", type: Types::BOOLEAN)]
    private bool $hasSetUp2fa;

    #[Column(name: "secret", type: Types::STRING)]
    private string $secret;

    #[Column(name: "account_status", type: Types::BOOLEAN)]
    private bool $accountStatus;

    public function __construct(string $email, string $password, bool $isAdmin, bool $hasSetUp2fa, bool $accountStatus) {
        $this->setEmail($email);
        $this->setIsAdmin($isAdmin);
        $this->setPassword($password);
        $this->setHasSetUp2fa($hasSetUp2fa);
        $this->secret = $this->generateTOTPSecret();
        $this->setAccountStatus($accountStatus);
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

    public function isAccountEnabled(): bool {
        return $this->accountStatus;
    }

    public function setAccountStatus(bool $status): void {
        $this->accountStatus = $status;
    }
}