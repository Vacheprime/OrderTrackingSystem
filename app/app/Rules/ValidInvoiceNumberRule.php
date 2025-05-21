<?php

namespace App\Rules;

use app\Utils\Utils;
use Closure;


class ValidInvoiceNumberRule implements BaseValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        

        // Execute secondary validation
        if ($value !== null && !Utils::validateInvoiceNumber($value)) {
            $fail("The invoice number is of invalid format!");
        }
    }

    /**
     * Get the preliminary validation rules.
     */
    private function getValidationRules(string $attribute): array {
        return [
            $attribute => "nullable|string"
        ];
    }

    /**
     * Get the preliminary error messages.
     */
    private function getErrorMessages(string $attribute): array {
        return [
            "$attribute.string" => "The invoice number must be text.",
        ];
    }
}
