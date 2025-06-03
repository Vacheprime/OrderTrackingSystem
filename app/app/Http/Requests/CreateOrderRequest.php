<?php

namespace App\Http\Requests;

use App\Http\Requests\Validation\ProductValidation;
use App\Rules\AddressFieldRules\ValidAppartmentNumberRule;
use App\Rules\AddressFieldRules\ValidAreaRule;
use App\Rules\AddressFieldRules\ValidPostalCodeRule;
use App\Rules\AddressFieldRules\ValidStreetRule;
use App\Rules\ClientFieldRules\ValidClientIdRule;
use App\Rules\ClientFieldRules\ValidReferenceNumberRule;
use App\Rules\EmployeeFieldRules\ValidEmployeeIdRule;
use App\Rules\OrderFieldRules\ValidEstimatedInstallDateRule;
use App\Rules\OrderFieldRules\ValidFabricationPlanImageRule;
use App\Rules\OrderFieldRules\ValidFabricationStartDateRule;
use App\Rules\OrderFieldRules\ValidInvoiceNumberRule;
use App\Rules\OrderFieldRules\ValidOrderStatusRule;
use App\Rules\OrderFieldRules\ValidTotalPriceRule;
use App\Rules\PersonFieldRules\ValidNameRule;
use App\Rules\PersonFieldRules\ValidPhoneNumberRule;
use App\Rules\ProductFieldRules\ValidMaterialNameRule;
use App\Rules\ProductFieldRules\ValidSlabDimensionRule;
use App\Rules\ProductFieldRules\ValidSlabSquareFootageRule;
use App\Rules\ProductFieldRules\ValidSlabThicknessRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    // Use the product validation from the product validation trait.
    use ProductValidation;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Managed by middleware
    }

    protected function prepareForValidation(): void {
        // Add default values for potentially missing fields
        $this->mergeIfMissing([
            "fabrication-image-input" => null,
            "invoice-number" => null,
            "fabrication-start-date-input" => null,
            "estimated-installation-date-input" => null,
            "material-name" => null,
            "slab-height" => null,
            "slab-width" => null,
            "slab-thickness" => null,
            "slab-square-footage" => null,
            "sink-type" => null,
            "product-description" => "",
            "product-notes" => "",
            "appartment-number" => null,
            "reference-number" => null
        ]);
    }

    public function after(): array {
        return [
            function ($validator) {
                $this->validateSlabFieldExistance($validator);
            },
            function ($validator) {
                $this->validateOrderProductPresent($validator);
            }
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Define the rules common to both types of create order requests
        $commonRules = [
                "measured-by" => [new ValidEmployeeIdRule],
                "invoice-number" => [new ValidInvoiceNumberRule],
                "total-price" => [new ValidTotalPriceRule],
                "order-status-select" => [new ValidOrderStatusRule],
                "fabrication-image-input" => [new ValidFabricationPlanImageRule],
                "fabrication-start-date-input" => [new ValidFabricationStartDateRule],
                "estimated-installation-date-input" => [new ValidEstimatedInstallDateRule],
                "material-name" => [new ValidMaterialNameRule],
                "slab-height" => [new ValidSlabDimensionRule],
                "slab-width" => [new ValidSlabDimensionRule],
                "slab-thickness" => [new ValidSlabThicknessRule],
                "slab-square-footage" => [new ValidSlabSquareFootageRule],
                "sink-type" => [new ValidMaterialNameRule],
                "product-description" => "nullable|string",
                "product-notes" => "nullable|string",
        ];

        // Rules for create with client ID
        if ($this->input("with-existing-client", "0") === "1") {
            return [
                "client-id" => [new ValidClientIdRule],
                ...$commonRules
            ];
        }

        // Rules for create with client info
        return [
            // Client Fields
            "first-name" => [new ValidNameRule],
            "last-name" => [new ValidNameRule],
            "street-name" => [new ValidStreetRule],
            "appartment-number" => [new ValidAppartmentNumberRule],
            "postal-code" => [new ValidPostalCodeRule],
            "area" => [new ValidAreaRule],
            "reference-number" => [new ValidReferenceNumberRule],
            "phone-number" => [new ValidPhoneNumberRule],
            ...$commonRules
        ];
    }
}
