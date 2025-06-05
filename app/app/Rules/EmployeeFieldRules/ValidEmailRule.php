<?php

namespace App\Rules\EmployeeFieldRules;

use app\Doctrine\ORM\Entity\Employee;
use App\Rules\BaseValidationRule;
use app\Utils\Utils;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidEmailRule extends BaseValidationRule
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
        // Check if the email is valid
        if (!Utils::validateEmail($value)) {
            $fail("The email is of invalid format.");
        }

        // Check if email was already used
        $employeeRepository = app("em")->getRepository(Employee::class);
        if ($employeeRepository->withEmail($value)->countFromCurrentQuery() > 0) {
            $fail("The email is already in use.");
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
            "$attribute.required" => "The email is required.",
            "$attribute.string" => "The email must be a string.",
        ];
    }
}
