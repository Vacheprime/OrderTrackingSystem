<?php

namespace App\Http\Requests;

use app\Doctrine\ORM\Entity\PaymentType;
use App\Rules\OrderFieldRules\ValidOrderIdRule;
use App\Rules\PaymentFieldRules\ValidPaymentAmountRule;
use App\Rules\PaymentFieldRules\ValidPaymentDateRule;
use App\Rules\PaymentFieldRules\ValidPaymentMethodRule;
use App\Rules\PaymentFieldRules\ValidPaymentTypeRule;
use Illuminate\Foundation\Http\FormRequest;
use DateTime;

class PaymentCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Managed by middleware
    }

    public function validated($key = null, $default = null)
    {
        // Get the validated data from the parent class
        $validated = parent::validated($key, $default);
        // Convert payment date to DateTime object
        $validated["payment-date-input"] = DateTime::createFromFormat("Y-m-d", $validated["payment-date-input"]);
        // Convert payment type to enum
        $validated["type-select"] = PaymentType::from(strtoupper($validated["type-select"]));
        // Convert the order id into an integer
        $validated["order-id"] = intval($validated["order-id"]);
        return $validated;
    }
    
    protected function prepareForValidation(): void
    {
        // Add default value for payment date if not provided
        if ($this->has("payment-date-input") && $this->input("payment-date-input") !== null) {
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
