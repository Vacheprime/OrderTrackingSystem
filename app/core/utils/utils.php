<?php

namespace app\core\utils;

class Utils {

    //  ### Global Validation Function
    /**
     * Checks whether the input string has space characters at its beginning
     * or end.
     * 
     * @param string $str The string to verify.
     * @return bool A boolean indicating whether $str has invalid space characters.
     */
    public static function hasInvalidSpaces(string $str): bool {
        return preg_match('/(^\s|\s$)/', $str) === 1;
    }

    //  ### Address Validation Functions ###
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

    //  ### Client Validation Functions ###
    /**
     * Checks whether a client reference is of valid format.
     * 
     * The format for a reference is a string ranging from 1 to 100
     * characters inclusively. Accepted characters are any uppercase or
     * lowercase letter of any language, apostrophes, dashes, digits, and
     * spaces. The reference cannot start or end with whitespace characters.
     * 
     * @param string $reference The reference to validate.
     * @return bool A boolean indicating whether the reference is valid.
     */
    public static function validateClientReference(string $reference): bool {
        if (Utils::hasInvalidSpaces($reference)) return false;
        return preg_match('/[\p{L}\d\'\- ]{1,100}/u', $reference) === 1;
    }

    // ### Employee Validation Functions ###
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

    /**
     * Checks whether initials are of valid format.
     * 
     * The format for initials is a string ranging from 1 to 10
     * characters inclusively. Accepted characters are any uppercase or
     * lowercase letters of any language, periods, and spaces. The initials
     * cannot start or end with whitespace characters.
     * 
     * @param string $initials The initials to validate.
     * @return bool A boolean indicating whether the initials are valid.
     */
    public static function validateInitials(string $initials) : bool {
        if (Utils::hasInvalidSpaces($initials)) return false;
        return preg_match('/^[\p{L}\. ]{1,10}$/u', $initials) === 1;
    }

    // ### Person Validation Functions ###
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