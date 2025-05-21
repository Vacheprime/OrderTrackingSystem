<?php

namespace App\Rules;

use app\Doctrine\ORM\Entity\Employee;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

class ValidEmployeeIdRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
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

        // Execute secondary validation (Business validation)
        // Get the employee repository
        $em = resolve("em");
        $employeeRepository = $em->getRepository(Employee::class);

        // Check if ID exists
        $employeeId = intval($value);
        if ($employeeRepository->find($employeeId) === null) {
            $fail("The employee ID does not match an existing employee.");
        }
    }

    /**
     * Get the preliminary validation rules for a valid employee ID field.
     */
    private function getValidationRules(string $attribute): array {
        return [
            $attribute => "required|integer|min:1"
        ];
    }

    /**
     * Get the preliminary error messages for an invalid employee ID field
     */
    private function getErrorMessages(string $attribute): array {
        return [
            "$attribute.required" => "The employee ID is required.",
            "$attribute.integer" => "The employee ID must be a number.",
            "$attribute.min" => "The employee ID must be at least :min or greater."
        ];
    }
}
