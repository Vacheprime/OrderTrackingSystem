<?php

namespace App\Rules\OrderFieldRules;

use App\Rules\BaseValidationRule;
use app\Doctrine\ORM\Entity\Order;
use Closure;

class ValidOrderIdRule extends BaseValidationRule
{
    private bool $isRequired;

    public function __construct(bool $isRequired = true)
    {
        $this->isRequired = $isRequired;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Ignore rule if the value is null and not required
        if (is_null($value) && !$this->isRequired) {
            return;
        }

        // Execute preliminary validation
        if (!$this->executePreliminaryValidation($attribute, $value, $fail)) {
            return; // fail fast
        }
        // Validate the order ID
        $em = app("em");
        $orderRepository = $em->getRepository(Order::class);
        
        $orderId = intval($value);
        if ($orderRepository->find($orderId) === null) {
            $fail("The order ID does not match an existing order.");
        }
    }

    /**
     * Get the preliminary validation rules.
     */
    protected function getValidationRules(string $attribute): array {
        return [
            $attribute => $this->isRequired ? "required|integer|min:1" : "nullable|integer|min:1"
        ];
    }

    /**
     * Get the preliminary error messages.
     */
    protected function getErrorMessages(string $attribute): array {
        return [
            "$attribute.required" => "The order ID is required.",
            "$attribute.integer" => "The order ID must be a number.",
            "$attribute.min" => "The order ID must be at least 1."
        ];
    }
}
