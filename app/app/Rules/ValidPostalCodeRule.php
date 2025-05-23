<?php

namespace App\Rules;

use app\Utils\Utils;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidPostalCodeRule extends BaseValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Execute preliminary validation
        if (!$this->executePreliminaryValidation($attribute, $value, $fail)) {
            return; // fail fast
        }

        if (!Utils::validatePostalCode($value)) {
            $fail("The postal code is of invalid format.");
        }
    }

    /**
     * Get the preliminary validation rules.
     */
    protected function getValidationRules(string $attribute): array {
        return [
            $attribute => "required|string"
        ];
    }

    /**
     * Get the preliminary error messages.
     */
    protected function getErrorMessages(string $attribute): array {
        return [
            "$attribute.required" => "The postal code is required.",
            "$attribute.string" => "The postal code must be text."
        ];
    }
}
