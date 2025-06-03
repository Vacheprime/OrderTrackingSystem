<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

abstract class BaseValidationRule implements ValidationRule
{
    /**
     * Run basic validation on the value based off the validation rules defined in
     * getValidationRules.
     */
    protected function executePreliminaryValidation(string $attribute, mixed $value, Closure $fail): bool {
        // Store the data
        $incomingInput = [$attribute => $value];
        // Get a validator
        $validator = Validator::make($incomingInput, $this->getValidationRules($attribute), $this->getErrorMessages($attribute));

        // Execute preliminary validation
        if ($validator->fails()) {
            // Get the message bag and return the first error message
            $messageBag = $validator->errors();
            $fail($messageBag->first($attribute));
            return false;
        }
        return true;
    }

    /**
     * Return the validation rules to be used for the rule.
     */
    abstract protected function getValidationRules(string $attribute);

    /**
     * Return the custom error messages associated with the validation rules.
     */
    abstract protected function getErrorMessages(string $attribute);
}
