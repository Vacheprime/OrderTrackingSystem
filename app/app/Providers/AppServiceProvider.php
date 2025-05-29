<?php

namespace App\Providers;

use app\Doctrine\ORM\Entity\Client;
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

        // Define model binding for the client model
        Route::bind("client", function (string $value) {
            return $this->findClient($value);
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

    /**
     * Find a client or return a 404 error page.
     */
    private function findClient(string $value) {
        if (!$this->isValidId($value)) {
            return abort(404, "Order not found.");
        }

        // Fetch the client
        $clientId = intval($value);
        $clientRepository = app("em")->getRepository(Client::class);

        $client = $clientRepository->find($clientId);
        return $client ?? abort(404, "Client not found");
    }

    /**
     * Check if a string is a valid ID integer.
     */
    private function isValidId(string $id): bool {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if ($id == false || $id < 1) {
            return false;
        }
        return true;
    }
}
