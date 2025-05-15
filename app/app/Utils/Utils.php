<?php

declare(strict_types = 1);

namespace app\Utils;
use DateTime;
use InvalidArgumentException;

class Utils {
    public static int $decimalScale = 15;

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

    /**
     * Checks whether a string is a valid decimal value.
     * 
     * @param string $str The decimal string to validate.
     * @param int $intDigits The number of integer digits in the decimal. Must be greater than or equal to 1.
     * @param int $fractDigits The number of fractional digits in the decimal. Must be greater than or equal to 1.
     * @return bool A boolean indicating whether the string is a valid decimal value. 
     */
    public static function validateStringDecimal(string $str, int $intDigits, int $fractDigits): bool {
        // Validate integer part
        if ($intDigits < 1) {
            throw new InvalidArgumentException("The number of integer digits must be greater than or equal to one!");
        }
        // Validate fractional part
        if ($fractDigits < 1) {
            throw new InvalidArgumentException("The number of fractional digits must be greater than or equal to one!");
        }
        $pattern = '/^-?\d{1,' . $intDigits . '}(?:\.\d{1,' . $fractDigits . '})?$/';
        return preg_match($pattern, $str) === 1;
    }

    /**
     * Checks whether an amount is greater than zero.
     * 
     * The amount is a string that must represent a valid
     * decimal number which contains 8 integer digits and 2 fractional digits.
     * The amount must be greater than 0.
     * 
     * @param string $amount The string decimal amount to validate.
     * @return bool A boolean indicating whether the amount is valid.
     */
    public static function validatePositiveAmount(string $amount): bool {
        if (!self::validateStringDecimal($amount, 8, 2)) return false;
        return bccomp($amount, "0", self::$decimalScale) === 1;
    }

    /**
     * Checks whether a date is set in the future.
     * 
     * @param DateTime $date The date to validate.
     * @return bool A boolean indicating whether the date is set in the future.
     */
    public static function validateDateInFuture(DateTime $date): bool {
        return $date > new DateTime("now");
    }

    /**
     * Checks whether a date is set in the past.
     * 
     * @param DateTime $date The date to validate.
     * @return bool A boolean indicating whether the date is set in the past.
     */
    public static function validateDateInPast(DateTime $date): bool {
        return $date < new DateTime("now");
    }

    /**
     * Checks whether a date is set in the past or the present moment.
     * 
     * @param DateTime $date The date to validate.
     * @return bool A boolean indicating whether the date is set in the past or the 
     * present moment.
     */
    public static function validateDateInPastOrNow(DateTime $date): bool {
        return $date <= new DateTime("now");
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
        if (self::hasInvalidSpaces($streetName)) return false;
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
        if (self::hasInvalidSpaces($aptNumber)) return false;
        return preg_match('/^[\p{L}\d\-\/\.]{1,15}$/u', $aptNumber) === 1;
    }

    /**
     * Checks whether a postal code is of proper format.
     * 
     * The format for a postal code is defined on the Canada Post website:
     * https://www.canadapost-postescanada.ca/cpc/en/support/articles/addressing-guidelines/postal-codes.page
     * It is of the format: ZDL DLD
     * where Z is one of the following letters: 
     * A B C E G H J K L M N P R S T V X Y
     * D is a digit, and L is an uppercase letter A-Z.
     * 
     * @param string $postalCode The postal code to validate.
     * @return bool A boolean indicating whether the postal code is valid.
     */
    public static function validatePostalCode(string $postalCode): bool {
        if (self::hasInvalidSpaces($postalCode)) return false;
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
        if (self::hasInvalidSpaces($area)) return false;
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
        if (self::hasInvalidSpaces($reference)) return false;
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
        if (self::hasInvalidSpaces($position)) return false;
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
        if (self::hasInvalidSpaces($initials)) return false;
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
        if (self::hasInvalidSpaces($name)) return false;
        return preg_match('/[\p{L}\'\- ]{1,50}/u', $name) === 1;
    }

    // ### Payment Validation Functions ###
    

    /**
     * Checks whether a payment method is valid.
     * 
     * The format for a payment method is a string ranging from 1 to 50
     * characters inclusively. Accepted characters are uppercase and lowercase
     * English letters, dashes, apostrophes, and spaces. The payment method
     * must not start or end with whitespace characters.
     * 
     * @param string $method The payment method to valid.
     * @return bool A boolean indicating whether the method is valid.
     */
    public static function validatePaymentMethod(string $method): bool {
        if (self::hasInvalidSpaces($method)) return false;
        return preg_match('/^[a-zA-Z\-\' ]{1,50}$/', $method) === 1;
    }

    // ### Order Validation Functions ###
    /**
     * Checks whether an invoice number is valid.
     * 
     * The format for an invoice number is a string ranging from
     * 1 to 100 characters inclusively. Accepted characters are uppercase
     * and lowercase English letters and digits.
     * 
     * @param string $invoiceNumber The invoice number to validate.
     * @return bool A boolean indicating whether the invoice number is valid.
     */
    public static function validateInvoiceNumber(string $invoiceNumber): bool {
        return preg_match('/^[a-zA-Z\d]{1,100}$/', $invoiceNumber) === 1;
    }

    // ### OrderProduct Validation Functions ###
    /**
     * Checks whether a material name or sink type is of valid format.
     * 
     * The format for a material name or sink type is a string ranging from 1 to 100 characters
     * inclusively. Accepted characters are any uppercase
     * or lowercase letters of any language, apostrophes, dashes, spaces, and numbers.
     * The material name or sink type cannot start or end with whitespace characters.
     * 
     * @param string $material The material name or sink type to validate.
     * @return bool A boolean indicating whether the material name or sink type is valid.
     */
    public static function validateMaterial(string $material): bool {
        if (self::hasInvalidSpaces($material)) return false;
        return preg_match('/[\p{L}\d\'\- ]{1,100}/u', $material) == 1;
    }

    /**
     * Checks whether the slab height or width is of valid format and range.
     * 
     * The format for a slab dimension is a string that must represent a valid
     * decimal number as defined in the validateStringDecimal() method. The value must be
     * positive and greater than zero. It must contain at most 6 digits, two of which
     * are decimal digits.
     * 
     * @param string $slab The slab dimension(height or width) to validate.
     * @return bool A boolean indicating whether the slab
     * dimension(height or width) is valid.
     */
    public static function validateSlabDimension(string $slabDimension): bool {
        if (!self::validateStringDecimal($slabDimension, 4, 2)) return false;
        return bccomp($slabDimension, "0", self::$decimalScale) === 1;
    }

    /**
     * Checks whether the slab thickness is of valid format and range.
     * 
     * The format for a slab thickness is a string that must represent a valid
     * decimal number as defined in the validateStringDecimal() method. The value
     * must be positive and greater than zero. It must contain at most 4 digits, two of which
     * are decimal digits.
     * 
     * @param string $slabThickness The slab thickness to validate.
     * @return bool A boolean indicating whether the slab thickness is valid.
     */
    public static function validateSlabThickness(string $slabThickness): bool {
        if (!self::validateStringDecimal($slabThickness, 2, 2)) return false;
        return bccomp($slabThickness, "0", self::$decimalScale) === 1;
    }

    /**
     * TO BE DELETED, KEPT FOR COMPATIBILITY. ALWAYS RETURNS TRUE.
     * 
     * Checks whether the image path is of valid format.
     * 
     * The format of the image path is a string ranging from 1 to 70, excluding the
     * dot and file extension(for a total of 75 characters inclusively). 
     * Accepted characters are any uppercase or lowercase letters of any language, apostrophes,
     * dashes,slashes, spaces, numbers, and symbols. No trailing spaces will be accepted, as well 
     * as illegal Window characters: \ / : * ? " < > |
     * 
     * Valid extensions are: 
     * png | jpg | jpeg | gif | webp | bmp
     * 
     * @param string $imagePath The image path to validate.
     * @return bool A boolean indicating whether the image path or extension is valid.
     */
    public static function validateImagePath(string $imagePath): bool {
        return true;
    }

    /**
     * Checks whether the square footage is of valid format.
     * 
     * The format of the product square footage is a string that must represent a valid
     * decimal number as defined in the validateStringDecimal() method. Tbe value must be
     * positive and greater than zero. It must contain at most 8 digits, two of which
     * are decimal digits.
     * 
     * @param string $squareFootage The product square footage to validate.
     * @return bool A boolean indicating whether the product square footage is valid.
     */
    public static function validateSlabSquareFootage(string $squareFootage): bool {
        if (!self::validateStringDecimal($squareFootage, 6, 2)) return false;
        return bccomp($squareFootage, "0", self::$decimalScale) === 1;
    }

    /**
     * Check whether an array contains at least one, non-null value.
     * 
     * @param array $arr The array to check.
     * @return bool A boolean indicating whether the array contains
     * at least one, non-null value.
     */
    public static function arrayHasValue(array $arr): bool {
        $hasValue = false;
        foreach ($arr as $key => $value) {
            if ($value !== null)  {
                $hasValue = true;
                break;
            }
        }
        return $hasValue;
    }
}