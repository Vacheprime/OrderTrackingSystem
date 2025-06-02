<?php

namespace App\Rules;

use app\Doctrine\ORM\Entity\Payment;
use app\Doctrine\ORM\Entity\PaymentType;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rules\Enum;

class ValidPaymentTypeRule extends BaseValidationRule
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

        // Validate the payment type
        $paymentType = PaymentType::tryFrom(strtoupper($value));
        if ($paymentType === null) {
            $fail("The payment type is not valid.");
            return;
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
            "$attribute.required" => "The payment type is required.",
            "$attribute.string" => "The payment type must be a valid string.",
        ];
    }
}
