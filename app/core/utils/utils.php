<?php

namespace core\utils;

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
}