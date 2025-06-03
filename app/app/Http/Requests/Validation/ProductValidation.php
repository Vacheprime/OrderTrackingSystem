<?php

namespace App\Http\Requests\Validation;

use app\Utils\Utils;
use Illuminate\Validation\Validator;

trait ProductValidation {

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
}