<?php

namespace App\Rules\AddressFieldRules;

use App\Rules\BaseValidationRule;
use app\Utils\Utils;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidAreaRule extends BaseValidationRule
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

        if (!Utils::validateArea($value)) {
            $fail("The area is of invalid format.");
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
            "$attribute.required" => "The area is required.",
            "$attribute.string" => "The area must be text."
        ];
    }
}
