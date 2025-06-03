<?php

namespace App\Rules\OrderFieldRules;

use App\Rules\BaseValidationRule;
use app\Utils\Utils;
use Closure;
use DateTime;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidFabricationStartDateRule extends BaseValidationRule
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

        // Validate fabrication start date
        $fabricationStartDate = DateTime::createFromFormat("Y-m-d", $value);
        if ($fabricationStartDate != false && !Utils::validateDateInPastOrNow($fabricationStartDate)) {
            $fail("The fabrication start date must be in the past or present.");
        }
    }

    /**
     * Get the preliminary validation rules.
     */
    protected function getValidationRules(string $attribute): array {
        return [
            $attribute => "nullable|date|date_format:Y-m-d"
        ];
    }

    /**
     * Get the preliminary error messages.
     */
    protected function getErrorMessages(string $attribute): array {
        return [
            "$attribute.date" => "The fabrication start date must be a date.",
            "$attribute.date_format" => "The format of the date must be Y-m-d"
        ];
    }
}
