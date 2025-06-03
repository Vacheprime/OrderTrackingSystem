<?php

namespace App\Rules\ClientFieldRules;

use App\Rules\BaseValidationRule;
use app\Utils\Utils;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidReferenceNumberRule extends BaseValidationRule
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
        
        if ($value !== null && !Utils::validateClientReference($value)) {
            $fail("The reference number is of invalid format.");
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
            "$attribute.string" => "The reference number must be text."
        ];
    }
}
