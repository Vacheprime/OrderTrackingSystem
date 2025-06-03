<?php

namespace App\Rules;

use Closure;
use App\Rules\BaseValidationRule;
use app\Utils\Utils;
use DateTime;

class ValidPaymentDateRule extends BaseValidationRule
{
    private bool $isRequired;

    public function __construct(bool $isRequired = false)
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
        // Ignore rule if the value is null and not required
        if (is_null($value) && !$this->isRequired) {
            return;
        }

        // Execute preliminary validation
        if (!$this->executePreliminaryValidation($attribute, $value, $fail)) {
            return; // fail fast
        }

        // Convert the value into a DateTime object
        $date = DateTime::createFromFormat("Y-m-d", $value);
        // Validate if the date is in the past or present
        if (!Utils::validateDateInPastOrNow($date)) {
            $fail("The payment date must be in the past or present.");
        }
    }

    /**
     * Get the preliminary validation rules.
     */
    protected function getValidationRules(string $attribute): array {
        return [
            $attribute => $this->isRequired ? "required|date|date_format:Y-m-d" : "nullable|date|date_format:Y-m-d"
        ];
    }

    /**
     * Get the preliminary error messages.
     */
    protected function getErrorMessages(string $attribute): array {
        return [
            "$attribute.date" => "The payment date must be a valid date.",
            "$attribute.date_format" => "The payment date must follow the format Y-m-d.",
            "$attribute.required" => "The payment date is required."
        ];
    }
}
