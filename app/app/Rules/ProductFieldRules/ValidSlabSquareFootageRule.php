<?php

namespace App\Rules\ProductFieldRules;

use App\Rules\BaseValidationRule;
use app\Utils\Utils;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidSlabSquareFootageRule extends BaseValidationRule
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
        
        // Validate the slab square footage
        if ($value !== null && !Utils::validateSlabSquareFootage($value)) {
            $fail("The slab square footage must be a positive number with at most 6 digits before the decimal point and at most 2 decimal places (e.g., 123456.78).");
        }
    }

    /**
     * Get the preliminary validation rules.
     */
    protected function getValidationRules(string $attribute): array {
        return [
            $attribute => "nullable|numeric"
        ];
    }

    /**
     * Get the preliminary error messages.
     */
    protected function getErrorMessages(string $attribute): array {
        return [
            "$attribute.numeric" => "The slab square footage must be a number."
        ];
    }
}
