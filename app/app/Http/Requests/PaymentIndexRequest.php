<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class PaymentIndexRequest extends FormRequest
{
    protected $redirect = "/payments";

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Managed by middleware 
    }

    /**
     * Prepare the data for validation.
     */
    protected function failedValidation(Validator $validator): void
    {
        // Use original failedValidation method if json is not requested.
        if (!$this->expectsJson()) {
            parent::failedValidation($validator);
            return;
        }

        // Return errors as json if json is requested
        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response()->json([
                "message" => "Invalid request.",
                "errors" => $validator->errors()
            ], 422)
        );
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Merge missing fields
        $this->mergeIfMissing([
            "page" => 1,
            "search" => "",
            "searchby" => "order-id",
            "paymentId" => 1
        ]);

        // Add default values for null values
        $input = $this->all();

        $input["page"] = $input["page"] ?? 1;
        $input["search"] = $input["search"] ?? "";
        $input["searchby"] = $input["searchby"] ?? "order-id";
        $input["paymentId"] = $input["paymentId"] ?? 1;

        // Replace the input with the modified input
        $this->replace($input);
    }

    public function after(): array {
        return [
            function ($validator) {
                $this->validateSearchBy($validator);
            },
            function ($validator) {
                $this->validateSearch($validator);
            }
        ];
    }

    private function validateSearchBy(Validator $validator): void {
        $searchBy = $this->input("searchby");
        $allowedFilters = ["order-id", "payment-id"];
        
        if (!in_array($searchBy, $allowedFilters)) {
            $validator->errors()->add("searchby", "Invalid search by value.");
        }
    }

    private function validateSearch(Validator $validator): void {
        $search = $this->input("search");
        $searchBy = $this->input("searchby");

        if (strlen($search) == 0) {
            return; // No search to validate
        }

        switch ($searchBy) {
            case "order-id":
                if (!is_numeric($search) || intval($search) <= 0) {
                    $validator->errors()->add("search-bar", "Order ID must be a positive integer.");
                }
                break;
            case "payment-id":
                if (!is_numeric($search) || intval($search) <= 0) {
                    $validator->errors()->add("search-bar", "Payment ID must be a positive integer.");
                }
                break;
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
            "page" => "nullable|int|min:1",
            "search" => "nullable|string",
            "searchby" => "nullable|string",
            "paymentId" => "nullable|int|min:1"
        ];
    }
}
