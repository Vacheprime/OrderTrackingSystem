<?php

namespace App\Rules\PaymentFieldRules;

use Closure;
use App\Rules\BaseValidationRule;
use app\Utils\Utils;

class ValidPaymentMethodRule extends BaseValidationRule
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

        // Validate the payment method using Utils::validatePaymentMethod
        if (!Utils::validatePaymentMethod($value)) {
            $fail("The payment method must be 50 characters or less and contain letters, dashes, apostrophes, or spaces.");
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
            "$attribute.required" => "The payment method is required.",
            "$attribute.string" => "The payment method must be a valid string.",
        ];
    }
}
