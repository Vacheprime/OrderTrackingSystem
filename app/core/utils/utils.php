<?php

namespace app\core\utils;

class Utils {

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