<?php

namespace App\Providers;

use app\Doctrine\ORM\Entity\Order;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Define model binding for the order model
        Route::bind("order", function (string $value) {
            return $this->findOrder($value);
        });
    }

    /**
     * Find an order or return a 404 error page.
     */
    private function findOrder(string $value) {
        // Get the entity manager and the order repository
        $em = app("em");
        $orderRepository = $em->getRepository(Order::class);

        // Validate the order id
        $orderId = filter_var($value, FILTER_VALIDATE_INT);
        if ($orderId === false || $orderId < 1) {
            return abort(404, "Order not found.");
        }

        // fetch the order
        $order = $orderRepository->find($orderId);

        return $order ?? abort(404, "Order not found.");
    }
}
