<?php

namespace App\Http\Requests;

use app\Doctrine\ORM\Entity\Employee;
use App\Rules\AddressFieldRules\ValidAppartmentNumberRule;
use App\Rules\AddressFieldRules\ValidAreaRule;
use App\Rules\AddressFieldRules\ValidPostalCodeRule;
use App\Rules\AddressFieldRules\ValidStreetRule;
use App\Rules\EmployeeFieldRules\ValidEmailRule;
use App\Rules\EmployeeFieldRules\ValidInitialsRule;
use App\Rules\EmployeeFieldRules\ValidPasswordRule;
use App\Rules\PersonFieldRules\ValidNameRule;
use App\Rules\PersonFieldRules\ValidPhoneNumberRule;
use Illuminate\Foundation\Http\FormRequest;

class AccountUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Managed by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Get the current employee which is being updated
        $employeeId = $this->session()->get("employee")["employeeID"];
        $employeeToEdit = app("em")->find(Employee::class, $employeeId);
        // Get the email to ignore for validation
        $emailToIgnore = $employeeToEdit->getAccount()->getEmail();

        return [
            "initials" => [new ValidInitialsRule],
            "first-name" => [new ValidNameRule],
            "last-name" => [new ValidNameRule],
            "email" => [new ValidEmailRule($emailToIgnore)],
            "phone-number" => [new ValidPhoneNumberRule],
            "street" => [new ValidStreetRule],
            "apartment-number" => [new ValidAppartmentNumberRule],
            "postal-code" => [new ValidPostalCodeRule],
            "area" => [new ValidAreaRule],
            "password" => [new ValidPasswordRule(false)], // Password is optional for updates
            "confirm-password" => "same:password",
        ];
    }
}
