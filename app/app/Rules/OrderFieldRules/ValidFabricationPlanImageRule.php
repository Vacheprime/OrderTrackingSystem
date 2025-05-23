<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidFabricationPlanImageRule extends BaseValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Execute preliminary validation
        $this->executePreliminaryValidation($attribute, $value, $fail);
        // No additional validation
    }

    /**
     * Get the preliminary validation rules.
     */
    protected function getValidationRules(string $attribute): array {
        return [
            $attribute => "nullable|file|mimes:jpg,jpeg,png,webp|max:10240"
        ];
    }

    /**
     * Get the preliminary error messages.
     */
    protected function getErrorMessages(string $attribute): array {
        return [
            "$attribute.file" => "The image selected must be a file.",
            "$attribute.mimes" => "The image must have a .jpg, .jpeg, .png, or .webp extension.",
            "$attribute.max" => "The image must be less than 10 MB in size."
        ];
    }
}
