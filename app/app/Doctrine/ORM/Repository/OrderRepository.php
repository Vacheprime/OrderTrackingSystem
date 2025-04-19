<?php

declare(strict_types = 1);

namespace app\Doctrine\ORM\Repository;

use Doctrine\ORM\EntityRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;

class OrderRepository extends EntityRepository {
    use PaginatesFromParams;

    public function getOrdersByStatusAscPaginated(): LengthAwarePaginator {
        
    }
}