<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

abstract class BaseValidationRule implements ValidationRule
{
    protected function executePreliminaryValidation(string $attribute, mixed $value, Closure $fail) {
        // Store the data
        $incomingInput = [$attribute => $value];
        // Get a validator
        $validator = Validator::make($incomingInput, $this->getValidationRules($attribute), $this->getErrorMessages($attribute));

        // Execute preliminary validation
        if ($validator->fails()) {
            // Get the message bag and return the first error message
            $messageBag = $validator->errors();
            $fail($messageBag->first($attribute));
        }
    }

    abstract protected function getValidationRules(string $attribute);

    abstract protected function getErrorMessages(string $attribute);
}
