<?php

namespace App\Http\Requests;

use app\Utils\Utils;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Validator;

class ClientIndexRequest extends FormRequest
{
    // Override default redirect url for failed validations
    protected $redirect = "/clients";

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Managed by middleware
    }

    /**
     * Override failedValidation method for returning errors as json if using Fetch api
     */
    protected function failedValidation(ValidationValidator $validator) {
        // Use original failedValidation method if json is not requested.
        if (!$this->expectsJson()) {
            parent::failedValidation($validator);
            return;
        }

        // Return errors as json if json is requested
        throw new HttpResponseException(
            response()->json([
                "message" => "Invalid request.",
                "errors" => $validator->errors()
            ], 422)
        );
    }

    protected function prepareForValidation(): void {
        // Merge missing fields
        $this->mergeIfMissing([
            "page" => 1,
            "search" => "",
            "searchby" => "client-id",
            "clientId" => 1
        ]);

        // Add default values for null values
        $input = $this->all();

        $input["page"] = $input["page"] ?? 1;
        $input["search"] = $input["search"] ?? "";
        $input["searchby"] = $input["searchby"] ?? "client-id";
        $input["clientId"] = $input["clientId"] ?? 1;

        // Replace
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

    private function validateSearchBy(Validator $validator) {
        // Get the input
        $searchBy = $this->input("searchby");
        // Define the allowed filters
        $allowedFilters = [
            "client-id",
            "name",
            "area"
        ];
        // Check if it is an allowed value
        if (in_array($searchBy, $allowedFilters)) {
            return;
        }
        // Add error otherwise
        $validator->errors()->add(
            "search-by-select",
            "The filter applied is not supported."
        );
    }

    private function validateSearch(Validator $validator) {
        // Get filter type
        $searchBy = $this->input("searchby");
        // Get search param
        $search = $this->input("search");

        // Skip if no search to apply
        if (strlen($search) == 0) {
            return;
        }

        // Validate the search param for each filter type
        switch ($searchBy) {
            // Validation for search as client id
            case "client-id":
                $clientId = filter_var($search, FILTER_VALIDATE_INT);
                // Validate if search is an integer
                if ($clientId === false ) {
                    $validator->errors()->add(
                        "search-bar",
                        "The client id must be a number."
                    );
                }
                // Validate if the id is in range
                if ($clientId < 1) {
                    $validator->errors()->add(
                        "search-bar",
                        "The client id must be greater than zero."
                    );
                }
                break;
            // Validation for search as first or last name
            case "name":
                if (Utils::validateName($search)) {
                    return;
                }
                // Add error
                $validator->errors()->add(
                    "search-bar",
                    "The name is of invalid format"
                );
                break;
            
            // Validation for search as area
            case "area":
                if (Utils::validateArea($search)) {
                    return;
                }
                // Add error
                $validator->errors()->add(
                    "search-bar",
                    "The area is of invalid format."
                );
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
            "orderby" => "nullable|string",
            "clientId" => "nullable|int|min:1"
        ];
    }
}
