<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use app\Rules\ValidClientIdRule;
use App\Rules\ValidEmployeeIdRule;
use App\Rules\ValidEstimatedInstallDateRule;
use App\Rules\ValidFabricationPlanImageRule;
use App\Rules\ValidFabricationStartDateRule;
use App\Rules\ValidInvoiceNumberRule;
use App\Rules\ValidMaterialNameRule;
use App\Rules\ValidOrderStatusRule;
use App\Rules\ValidSlabDimensionRule;
use App\Rules\ValidSlabSquareFootageRule;
use App\Rules\ValidSlabThicknessRule;
use App\Rules\ValidTotalPriceRule;

class CreateOrderWithClientIdRequest extends FormRequest
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
            "client-id" => [new ValidClientIdRule],
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
    }
}
