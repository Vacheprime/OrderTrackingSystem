<?php

namespace App\Http\Requests;

use App\Rules\AddressFieldRules\ValidAppartmentNumberRule;
use App\Rules\AddressFieldRules\ValidAreaRule;
use App\Rules\AddressFieldRules\ValidPostalCodeRule;
use App\Rules\AddressFieldRules\ValidStreetRule;
use App\Rules\EmployeeFieldRules\ValidEmailRule;
use App\Rules\EmployeeFieldRules\ValidInitialsRule;
use App\Rules\EmployeeFieldRules\ValidPasswordRule;
use App\Rules\EmployeeFieldRules\ValidPositionRule;
use App\Rules\PersonFieldRules\ValidNameRule;
use App\Rules\PersonFieldRules\ValidPhoneNumberRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeCreateRequest extends FormRequest
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
        return [
            "initials" => [new ValidInitialsRule],
            "first-name" => [new ValidNameRule],
            "last-name" => [new ValidNameRule],
            "position" => [new ValidPositionRule],
            "email" => [new ValidEmailRule],
            "phone-number" => [new ValidPhoneNumberRule],
            "address-street" => [new ValidStreetRule],
            "address-apt-num" => [new ValidAppartmentNumberRule],
            "postal-code" => [new ValidPostalCodeRule],
            "area" => [new ValidAreaRule],
            "password" => [new ValidPasswordRule],
            "confirm-password" => "same:password"
        ];
    }

    public function messages() : array {
        return [
            "confirm-password.same" => "The passwords entered do not match.",
        ];
    }
}
