<?php

namespace App\Http\Requests;

use App\Rules\AddressFieldRules\ValidAppartmentNumberRule;
use App\Rules\AddressFieldRules\ValidAreaRule;
use App\Rules\AddressFieldRules\ValidPostalCodeRule;
use App\Rules\AddressFieldRules\ValidStreetRule;
use App\Rules\EmployeeFieldRules\ValidAccountStatusRule;
use App\Rules\EmployeeFieldRules\ValidAdminStatusRule;
use App\Rules\EmployeeFieldRules\ValidEmailRule;
use App\Rules\EmployeeFieldRules\ValidInitialsRule;
use App\Rules\EmployeeFieldRules\ValidPasswordRule;
use App\Rules\EmployeeFieldRules\ValidPositionRule;
use App\Rules\PersonFieldRules\ValidNameRule;
use App\Rules\PersonFieldRules\ValidPhoneNumberRule;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Managed by middleware
    }

    protected function prepareForValidation(): void
    {
        // Add default values for optional fields
        $this->mergeIfMissing([
            "password" => "",
            "confirm-password" => ""
        ]);
    }

    public function validated($key = null, $default = null) {
        $validatedData = parent::validated($key, $default);

        // Convert account status to a boolean
        $accountStatus = strtolower($validatedData["account-status-select"]);
        if ($accountStatus == "enabled") {
            $validatedData["account-status-select"] = true;
        } else if ($accountStatus == "disabled") {
            $validatedData["account-status-select"] = false;
        }

        // Convert admin status to a boolean
        $isAdmin = strtolower($validatedData["admin-status-select"]);
        if ($isAdmin == "enabled") {
            $validatedData["admin-status-select"] = true;
        } else if ($isAdmin == "disabled") {
            $validatedData["admin-status-select"] = false;
        }

        return $validatedData;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Get the employee being edited
        $employeeToEdit = $this->route("employee");
        // Get the email to ignore for validation
        $emailToIgnore = $employeeToEdit->getAccount()->getEmail();

        return [
            "initials" => [new ValidInitialsRule],
            "first-name" => [new ValidNameRule],
            "last-name" => [new ValidNameRule],
            "position" => [new ValidPositionRule],
            "email" => [new ValidEmailRule($emailToIgnore)],
            "phone-number" => [new ValidPhoneNumberRule],
            "address-street" => [new ValidStreetRule],
            "address-apt-num" => [new ValidAppartmentNumberRule],
            "postal-code" => [new ValidPostalCodeRule],
            "area" => [new ValidAreaRule],
            "password" => [new ValidPasswordRule(false)], // Password is optional for updates
            "confirm-password" => "same:password",
            "admin-status-select" => [new ValidAdminStatusRule],
            "account-status-select" => [new ValidAccountStatusRule]
        ];
    }

    public function messages() : array {
        return [
            "confirm-password.same" => "The passwords entered do not match.",
        ];
    }
}
