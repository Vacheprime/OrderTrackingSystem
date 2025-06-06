<?php

namespace App\Http\Requests;

use app\Doctrine\ORM\Entity\Order;
use App\Http\Requests\Validation\ProductValidation;
use App\Rules\OrderFieldRules\ValidEstimatedInstallDateRule;
use App\Rules\OrderFieldRules\ValidFabricationPlanImageRule;
use App\Rules\OrderFieldRules\ValidFabricationStartDateRule;
use App\Rules\OrderFieldRules\ValidInvoiceNumberRule;
use App\Rules\OrderFieldRules\ValidOrderStatusRule;
use App\Rules\OrderFieldRules\ValidTotalPriceRule;
use App\Rules\ProductFieldRules\ValidMaterialNameRule;
use App\Rules\ProductFieldRules\ValidSlabDimensionRule;
use App\Rules\ProductFieldRules\ValidSlabSquareFootageRule;
use App\Rules\ProductFieldRules\ValidSlabThicknessRule;
use app\Utils\Utils;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use DateTime;

class OrderUpdateRequest extends FormRequest
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
        $this->mergeIfMissing([
            "invoice-number" => null,
            "fabrication-image-input" => null,
            "fabrication-start-date-input" => null,
            "estimated-installation-date-input" => null,
            "material-name" => null,
            "slab-height" => null,
            "slab-width" => null,
            "slab-thickness" => null,
            "slab-square-footage" => null,
            "sink-type" => null,
            "product-description" => "",
            "product-notes" => ""
        ]);

        if ($this->input("product-description") === null) {
            $this->merge(["product-description" => ""]);
        }

        if ($this->input("product-notes") === null) {
            $this->merge(["product-notes" => ""]);
        }
    }

    public function after(): array {
        return [
            function ($validator) {
                $this->validateSlabFieldExistance($validator);
            },
            function ($validator) {
                $this->validateOrderProductPresent($validator);
            },
            function ($validator) {
                $this->validateEstimatedDate($validator);
            }
        ];
    }

    private function validateEstimatedDate(Validator $validator) {
        // Get the order
        $order = $this->route("order");
        // Get the key and value
        $key = "estimated-installation-date-input";
        $value = $this->input($key);

        // Validate installation start date
        $estInstallDate = DateTime::createFromFormat("Y-m-d", $value);
        if ($estInstallDate != false && !Utils::validateDateInFuture($estInstallDate)) {
            // Pass the validation if the value stays the same
            $currentEstimatedDate = $order->getEstimatedInstallDate();
            if ($currentEstimatedDate !== null && $estInstallDate->format("Y-m-d") == $currentEstimatedDate->format("Y-m-d")) {
                return;
            }
            // Notify of error
            $validator->errors()->add(
                $key,
                "The estimated install date must be in the future."
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
        return [
            "invoice-number" => [new ValidInvoiceNumberRule],
            "total-price" => [new ValidTotalPriceRule],
            "order-status-select" => [new ValidOrderStatusRule],
            "fabrication-image-input" => [new ValidFabricationPlanImageRule],
            "fabrication-start-date-input" => [new ValidFabricationStartDateRule],
            "estimated-installation-date-input" => "nullable|date|date_format:Y-m-d",
            "material-name" => [new ValidMaterialNameRule],
            "slab-height" => [new ValidSlabDimensionRule],
            "slab-width" => [new ValidSlabDimensionRule],
            "slab-thickness" => [new ValidSlabThicknessRule],
            "slab-square-footage" => [new ValidSlabSquareFootageRule],
            "sink-type" => [new ValidMaterialNameRule],
            "product-description" => "nullable|string",
            "product-notes" => "nullable|string",
        ];
    }
}
