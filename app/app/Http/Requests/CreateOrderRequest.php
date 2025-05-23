<?php

namespace App\Http\Requests;

use App\Rules\ValidAppartmentNumberRule;
use App\Rules\ValidAreaRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidClientIdRule;
use App\Rules\ValidEmployeeIdRule;
use App\Rules\ValidEstimatedInstallDateRule;
use App\Rules\ValidFabricationPlanImageRule;
use App\Rules\ValidFabricationStartDateRule;
use App\Rules\ValidInvoiceNumberRule;
use App\Rules\ValidMaterialNameRule;
use App\Rules\ValidNameRule;
use App\Rules\ValidOrderStatusRule;
use App\Rules\ValidPhoneNumberRule;
use App\Rules\ValidPostalCodeRule;
use App\Rules\ValidReferenceNumberRule;
use App\Rules\ValidSlabDimensionRule;
use App\Rules\ValidSlabSquareFootageRule;
use App\Rules\ValidSlabThicknessRule;
use App\Rules\ValidStreetRule;
use App\Rules\ValidTotalPriceRule;
use app\Utils\Utils;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;

class CreateOrderRequest extends FormRequest
{
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
     * Validate that the material, height, width, thickness, and square footage are
     * present if one of those fields is present.
     */
    public function validateSlabFieldExistance(Validator $validator) {
        // Define the slab fields
        $slabFields = [
            "material-name" => $this->input("material-name"),
            "slab-width" => $this->input("slab-width"),
            "slab-height" => $this->input("slab-height"),
            "slab-thickness" => $this->input("slab-thickness"),
            "slab-square-footage" => $this->input("slab-square-footage")
        ];

        // Check if all values are present, if one is present
        if (!Utils::arrayHasValue($slabFields)) {
            return;
        }

        // Loop over every field to find the one that has been left empty
        foreach($slabFields as $name => $value) {
            // Check if the field is not null
            if (!is_null($value)) {
                continue;
            }
            // Add the error if null
            $validator->errors()->add(
            $name,
                "This field cannot be left empty if the order contains a slab."
            );
        }
    }

    /**
     * Validate that at least the sink or the slab information is specified.
     */
    public function validateOrderProductPresent(Validator $validator) {
        // Define the slab fields
        $productFields = [
            "material-name" => $this->input("material-name"),
            "slab-width" => $this->input("slab-width"),
            "slab-height" => $this->input("slab-height"),
            "slab-thickness" => $this->input("slab-thickness"),
            "slab-square-footage" => $this->input("slab-square-footage"),
            "sink-type" => $this->input("sink-type")
        ];

        // Check if a value is present
        if (Utils::arrayHasValue($productFields)) {
            return;
        }

        // Add error message to all product fields
        foreach ($productFields as $name => $value) {
            $validator->errors()->add(
                $name,
                "Either the slab or sink information must be filled out."
            );
        }
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
