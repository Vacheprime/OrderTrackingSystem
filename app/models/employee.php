<?php

declare(strict_types = 1);

namespace app\models;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\GeneratedValue;
use OTPHP\TOTP;

use app\core\utils\Utils;
use DateTime;
use InvalidArgumentException;

require_once(dirname(__DIR__)."/vendor/autoload.php");
require_once(dirname(__DIR__)."/core/utils/utils.php");
require_once("address.php");
require_once("person.php");

#[Entity]
#[Table(name: "employee")]
class Employee extends Person {
    #[Id]
    #[Column(name: "employee_id", type: Types::INTEGER), GeneratedValue("AUTO")]
    private ?int $employeeId = null;
 
    #[Column(name: "position", type: Types::STRING)]
    private string $position;

    #[Column(name: "email", type: Types::STRING)]
    private string $email;

    #[Column(name: "birth_date", type: Types::DATE_MUTABLE)]
    private DateTime $birthDate;

    #[Column(name: "hire_date", type: Types::DATE_MUTABLE)]
    private DateTime $hireDate;

    #[Column(name: "is_admin", type: Types::BOOLEAN)]
    private bool $isAdmin;

    #[Column(name: "password_hash", type: Types::STRING)]
    private string $passwordHash;

    #[Column(name: "secret", type: Types::STRING)]
    private string $secret;

    public function __construct(
        string $firstName,
        string $lastName,
        string $phoneNumber,
        Address $address,
        string $position,
        string $email,
        DateTime $birthDate,
        DateTime $hireDate,
        bool $isAdmin,
        string $password
    ) {
        // Use setters because they include input validation.
        parent::__construct($firstName, $lastName, $phoneNumber, $address);
        $this->setPosition($position);
        $this->setEmail($email);
        $this->setBirthDate($birthDate);
        $this->setHireDate($hireDate);
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

    public function getPosition(): string {
        return $this->position;
    }

    public function setPosition(string $position): void {
        if (!Employee::validatePosition($position)) {
            throw new InvalidArgumentException("The position is invalid!");
        }
        $this->position = $position;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        if (!Employee::validateEmail($email)) {
            throw new InvalidArgumentException("The email is invalid!");
        }
        $this->email = $email;
    }

    public function getBirthDate(): DateTime {
        return $this->birthDate;
    }

    public function setBirthDate(DateTime $birthDate): void {
        if (!Employee::validateBirthDate($birthDate)) {
            throw new InvalidArgumentException("The birth date is invalid!");
        }
        $this->birthDate = $birthDate;
    }

    public function getHireDate(): DateTime {
        return $this->hireDate;
    }

    public function setHireDate(DateTime $hireDate): void {
        if (!Employee::validateHireDate($hireDate)) {
            throw new InvalidArgumentException("The hire date is invalid!");
        }
        $this->hireDate = $hireDate;
    }

    public function isAdmin(): bool {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): void {
        $this->isAdmin = $isAdmin;
    }

    public function getPasswordHash(): string {
        return $this->passwordHash;
    }

    public function setPassword(string $password): void {
        if (!self::validatePassword($password)) {
            throw new InvalidArgumentException("The password is invalid!");
        }
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }

    public function getSecret(): string {
        return $this->secret;
    }

    /**
     * Checks whether a position is of proper format.
     * 
     * The format for a position is a string ranging from 1 to 25
     * characters inclusively. Accepted characters are any uppercase or
     * lowercase letters of any language, digits, apostrophes, dashes, and 
     * spaces. The position cannot start of end with whitespace characters.
     * 
     * @param string $position The position to validate.
     * @return bool A boolean indicating whether the position is valid.
     */
    public static function validatePosition(string $position): bool {
        if (Utils::hasInvalidSpaces($position)) return false;
        return preg_match('/^[\p{L}\d\'\- ]{1,25}$/u', $position) === 1;
    }

    /**
     * Checks whether an email is of proper format.
     * 
     * The format for an email is defined by the FILTER_VALIDATE_EMAIL.
     * The email must be less than or equal to 75 characters in length.
     * 
     * @param string $email The email to validate.
     * @return bool A boolean indicating whether the email is valid.
     */
    public static function validateEmail(string $email): bool {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) <= 75) {
            return true;
        }
        return false;
    }

    /**
     * Checks whether the birth date is valid.
     * 
     * A valid birth date is a date set in the past.
     * 
     * @param DateTime $birthDate The birth date to validate.
     * @return bool A boolean indicating whether the birth day is valid.
     */
    public static function validateBirthDate(DateTime $birthDate): bool {
        return $birthDate < new DateTime("now");
    }

    /**
     * Checks whether the hire date is valid.
     * 
     * A valid hire date is a date set in the past or the present.
     * 
     * @param DateTime $hireDate The hire date to validate.
     * @return bool A boolean indicating whether the hire day is valid.
     */
    public static function validateHireDate(DateTime $hireDate): bool {
        return $hireDate <= new DateTime("now");
    }

    /**
     * Checks whether a password is of valid format and is strong enough.
     * 
     * A password must range from 12 to 100 characters inclusively. 
     * It must contain an uppercase and lowercase English character, a digit, and
     * a special character. Spaces are not accepted. The regex used was found on
     * the following website:
     * https://uibakery.io/regex-library/password-regex-php
     * 
     * @param string $password The password to validate.
     * @return bool A boolean indicating whether the password is valid.
     */
    public static function validatePassword(string $password): bool {
        if (preg_match('/\s/', $password)) return false;
        return preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{12,100}$/', $password) === 1;
    }
}