<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderIndexRequest extends FormRequest
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
            "page" => 1,
            "search" => "",
            "searchby" => "order-id",
            "orderby" => "status",
            "orderId" => 1
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
            "page" => "nullable|int|min:1",
            "search" => "nullable|string",
            "searchby" => "nullable|string",
            "orderby" => "nullable|string",
            "orderId" => "nullable|int" // Kept for compatibility
        ];
    }
}
