<?php

namespace App\Providers;

use app\Doctrine\ORM\Entity\Client;
use app\Doctrine\ORM\Entity\Order;
use app\Doctrine\ORM\Entity\Payment;
use app\Doctrine\ORM\Entity\Employee;
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
            return $this->findEntity(Order::class, $value, "Order not found.");
        });

        // Define model binding for the client model
        Route::bind("client", function (string $value) {
            return $this->findEntity(Client::class, $value, "Client not found.");
        });

        // Define model binding for the payment model
        Route::bind("payment", function (string $value) {
            return $this->findEntity(Payment::class, $value, "Payment not found.");
        });

        // Define model binding for the employee model
        Route::bind("employee", function (string $value) {
            return $this->findEntity(Employee::class, $value, "Employee not found.");
        });
    }

    /**
     * Generic method to find an entity or return a 404 error page.
     */
    private function findEntity(string $entityClass, string $value, string $errorMessage)
    {
        // Validate the ID
        $id = filter_var($value, FILTER_VALIDATE_INT);
        if ($id === false || $id < 1) {
            abort(404, $errorMessage);
        }

        // Fetch the entity
        $repository = app("em")->getRepository($entityClass);
        $entity = $repository->find($id);

        return $entity ?? abort(404, $errorMessage);
    }
}
