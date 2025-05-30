<?php

namespace App\Http\Requests;

use App\Rules\AddressFieldRules\ValidAppartmentNumberRule;
use App\Rules\AddressFieldRules\ValidAreaRule;
use App\Rules\AddressFieldRules\ValidPostalCodeRule;
use App\Rules\AddressFieldRules\ValidStreetRule;
use App\Rules\ClientFieldRules\ValidReferenceNumberRule;
use App\Rules\PersonFieldRules\ValidNameRule;
use App\Rules\PersonFieldRules\ValidPhoneNumberRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class ClientUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Managed by middleware
    }

    protected function prepareForValidation(): void {
        $this->mergeIfMissing([
            "apartment-number" => null,
            "reference-number" => null
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "first-name" => [new ValidNameRule],
            "last-name" => [new ValidNameRule],
            "reference-number" => [new ValidReferenceNumberRule],
            "phone-number" => [new ValidPhoneNumberRule],
            "street" => [new ValidStreetRule],
            "apartment-number" => [new ValidAppartmentNumberRule],
            "postal-code" => [new ValidPostalCodeRule],
            "area" => [new ValidAreaRule],
        ];
    }
}
