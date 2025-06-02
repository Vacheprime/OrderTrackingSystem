<?php

namespace App\Http\Requests;

use App\Rules\OrderFieldRules\ValidOrderIdRule;
use App\Rules\PaymentFieldRules\ValidPaymentAmountRule;
use App\Rules\ValidPaymentDateRule;
use App\Rules\ValidPaymentMethodRule;
use App\Rules\ValidPaymentTypeRule;
use Illuminate\Foundation\Http\FormRequest;

class PaymentCreateRequest extends FormRequest
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
        // Add default value for payment date if not provided
        if ($this->has("payment-date-input")) {
            return;
        }

        // Default value for payment date is today
        $this->merge([
            "payment-date-input" => now()->format("Y-m-d")
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
            "order-id" => [new ValidOrderIdRule(true)],
            "payment-date-input" => [new ValidPaymentDateRule(false)],
            "amount" => [new ValidPaymentAmountRule],
            "type-select" => [new ValidPaymentTypeRule],
            "method" => [new ValidPaymentMethodRule]
        ];
    }
}
