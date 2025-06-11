<?php

namespace App\Rules\PaymentFieldRules;

use Closure;
use App\Rules\BaseValidationRule;
use app\Utils\Utils;

class ValidPaymentAmountRule extends BaseValidationRule
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

        // Validate the payment amount using Utils::validatePositiveAmount
        if (!Utils::validatePositiveAmount($value)) {
            $fail("The payment amount must be a positive number greater than zero and can contain at most 8 digits before the decimal and at most 2 decimals (e.g., 12345678.91).");
        }
    }

    /**
     * Get the preliminary validation rules.
     */
    protected function getValidationRules(string $attribute): array {
        return [
            $attribute => "required|numeric|min:0.01"
        ];
    }

    /**
     * Get the preliminary error messages.
     */
    protected function getErrorMessages(string $attribute): array {
        return [
            "$attribute.required" => "The payment amount is required.",
            "$attribute.numeric" => "The payment amount must be a number.",
            "$attribute.min" => "The payment amount must be at least 0.01."
        ];
    }
}
