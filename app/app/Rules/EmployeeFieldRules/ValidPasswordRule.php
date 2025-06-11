<?php

namespace App\Rules\EmployeeFieldRules;

use App\Rules\BaseValidationRule;
use app\Utils\Utils;
use Closure;

class ValidPasswordRule extends BaseValidationRule
{
    private bool $isRequired = true;

    public function __construct(bool $isRequired = true)
    {
        $this->isRequired = $isRequired;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->isRequired && (empty($value) || is_null($value))) {
            return; // If not required and empty, skip validation
        }

        // Execute preliminary validation
        if (!$this->executePreliminaryValidation($attribute, $value, $fail)) {
            return; // fail fast
        }
        // Execute secondary validation (Business validation)
        // Check if the password is valid
        if (!Utils::validatePassword($value)) {
            $fail("The password must range from 12 to 100 characters and contain an uppercase and lowercase letter, a digit, and a special character.");
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
            "$attribute.required" => "The password is required.",
            "$attribute.string" => "The password must be a string.",
        ];
    }
}
