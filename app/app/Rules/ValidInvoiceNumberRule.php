<?php

namespace App\Rules;

use app\Utils\Utils;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

class ValidInvoiceNumberRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Store the data
        $incomingInput = [$attribute => $value];
        // Get a validator
        $validator = Validator::make($incomingInput, $this->getValidationRules($attribute), $this->getErrorMessages($attribute));

        // Execute preliminary validation
        if ($validator->fails()) {
            // Get the message bag and return the first error message
            $messageBag = $validator->errors();
            $fail($messageBag->first($attribute));
        }

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
