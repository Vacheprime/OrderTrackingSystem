<?php

namespace App\Http\Requests;

use app\Utils\Utils;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeIndexRequest extends FormRequest
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
        // Merge missing fields
        $this->mergeIfMissing([
            "page" => 1,
            "search" => "",
            "searchby" => "employee-id",
            "employeeId" => 1
        ]);

        // Add default values for null values
        $input = $this->all();

        $input["page"] = $input["page"] ?? 1;
        $input["search"] = $input["search"] ?? "";
        $input["searchby"] = $input["searchby"] ?? "employee-id";
        $input["employeeId"] = $input["employeeId"] ?? 1;

        $this->replace($input);
    }

    public function after(): array {
        return [
            function (Validator $validator) {
                $this->validateSearchBy($validator);
            },
            function (Validator $validator) {
                $this->validateSearch($validator);
            }
        ];
    }

    private function validateSearchBy(Validator $validator) {
        $searchBy = $this->input("searchby");
        $allowedFilters = ["employee-id", "name", "position"];

        if (!in_array($searchBy, $allowedFilters)) {
            $validator->errors()->add("searchby", "Invalid search by value.");
        }
    }

    private function validateSearch(Validator $validator) {
        $search = $this->input("search");
        $searchby = $this->input("searchby");

        if (strlen($search) == 0) {
            return; // No search term provided, no validation needed
        }

        switch ($searchby) {
            case "employee-id":
                if (!is_numeric($search) || intval($search) <= 0) {
                    $validator->errors()->add("search", "Invalid employee ID.");
                }
                break;
            case "name":
                if (!Utils::validateName($search)) {
                    $validator->errors()->add("search", "The name is of invalid format.");
                }
                break;
            case "position":
                if (!Utils::validatePosition($search)) {
                    $validator->errors()->add("search", "The position is of invalid format.");
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
            "employeeId" => "nullable|int|min:1"
        ];
    }
}
