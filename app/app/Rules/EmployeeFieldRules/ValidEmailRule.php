<?php

namespace App\Rules\EmployeeFieldRules;

use app\Doctrine\ORM\Entity\Employee;
use App\Rules\BaseValidationRule;
use app\Utils\Utils;
use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class ValidEmailRule extends BaseValidationRule
{
    private ?string $emailToIgnore;

    public function __construct(?string $emailToIgnore = null)
    {
        $this->emailToIgnore = strtolower($emailToIgnore);
    }

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
            $fail("The email must be 75 characters or less and must be a valid.");
        }

        // Ignore the check if the email is the same as the current employee being edited
        if (!is_null($this->emailToIgnore) && strtolower($value) == $this->emailToIgnore) {
            return;
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
