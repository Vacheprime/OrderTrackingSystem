<?php

namespace App\Rules\EmployeeFieldRules;

use App\Rules\BaseValidationRule;
use Closure;
class ValidAdminStatusRule extends BaseValidationRule
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
            return; // fail-fast
        }

        // Check if admin status is disabled or enabled
        $allowedValues = ["enabled", "disabled"];
        if (!in_array(strtolower($value), $allowedValues)) {
            $fail("The admin status must be either 'disabled' or 'enabled'.");
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
            "$attribute.required" => "The admin status is required.",
            "$attribute.string" => "The admin status must be a string.",
        ];
    }
}
