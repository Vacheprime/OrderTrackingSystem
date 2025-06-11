<?php

namespace App\Rules\OrderFieldRules;

use App\Rules\BaseValidationRule;
use app\Utils\Utils;
use Closure;


class ValidInvoiceNumberRule extends BaseValidationRule
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

        // Execute secondary validation
        if ($value !== null && !Utils::validateInvoiceNumber($value)) {
            $fail("The invoice number must be 100 characters or less and can contain letters, digits, dashes, plus signs, and spaces.");
        }
    }

    /**
     * Get the preliminary validation rules.
     */
    protected function getValidationRules(string $attribute): array {
        return [
            $attribute => "nullable|string"
        ];
    }

    /**
     * Get the preliminary error messages.
     */
    protected function getErrorMessages(string $attribute): array {
        return [
            "$attribute.string" => "The invoice number must be text.",
        ];
    }
}
