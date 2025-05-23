<?php

namespace App\Rules;

use app\Doctrine\ORM\Entity\Client;
use Closure;

class ValidClientIdRule extends BaseValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Execute preliminary validation
        if (!$this->executePreliminaryValidation($attribute, $value, $fail)) {
            return; // fail fast
        }

        // Get the client repository
        $em = resolve("em");
        $clientRepository = $em->getRepository(Client::class);

        // Check if ID exists
        $clientId = intval($value);
        if ($clientRepository->find($clientId) === null) {
            $fail("The client ID does not match an existing client.");
        }
    }

    /**
     * Get the preliminary validation rules.
     */
    protected function getValidationRules(string $attribute): array {
        return [
            $attribute => "required|integer|min:1"
        ];
    }

    /**
     * Get the preliminary error messages.
     */
    protected function getErrorMessages(string $attribute): array {
        return [
            "$attribute.required" => "The client ID is required.",
            "$attribute.integer" => "The client ID must be a number.",
            "$attribute.min" => "The client ID must be at least :min or greater."
        ];
    }
}
