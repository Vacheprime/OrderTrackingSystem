<?php

namespace App\Rules\AddressFieldRules;

use app\Utils\Utils;
use App\Rules\BaseValidationRule;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidAppartmentNumberRule extends BaseValidationRule
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

        if ($value !== null && !Utils::validateAptNumber($value)) {
            $fail("The apartment number must be 15 characters or less, and can only contain letters, spaces, numbers, and the following characters: - . /");
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
            "$attribute.string" => "The apartment number must be text."
        ];
    }
}
