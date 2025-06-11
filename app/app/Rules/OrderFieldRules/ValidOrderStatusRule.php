<?php

namespace App\Rules\OrderFieldRules;

use App\Rules\BaseValidationRule;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use app\Doctrine\ORM\Entity\Status;

class ValidOrderStatusRule extends BaseValidationRule
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

        // Validate order status
        if (Status::tryFrom(strtoupper($value)) === null) {
            $fail("The order status must be 'measuring', 'ordering_material', 'fabricating', 'ready_to_handover', 'installed', or 'picked_up'.");
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
            "$attribute.required" => "The order status is required.",
            "$attribute.string" => "The order status must be text."
        ];
    }
}
