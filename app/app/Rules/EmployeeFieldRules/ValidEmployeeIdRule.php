<?php

namespace App\Rules\EmployeeFieldRules;

use App\Rules\BaseValidationRule;
use app\Doctrine\ORM\Entity\Employee;
use Closure;
use Illuminate\Support\Facades\Validator;

class ValidEmployeeIdRule extends BaseValidationRule
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
     * Get the preliminary validation rules.
     */
    protected function getValidationRules(string $attribute): array {
        return [
            $attribute => "required|integer|min:1"
        ];
    }

    /**
     * Get the preliminary error messages.
     */
    protected function getErrorMessages(string $attribute): array {
        return [
            "$attribute.required" => "The employee ID is required.",
            "$attribute.integer" => "The employee ID must be a number.",
            "$attribute.min" => "The employee ID must be at least :min or greater."
        ];
    }
}
