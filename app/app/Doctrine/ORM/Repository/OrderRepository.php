<?php

declare(strict_types = 1);

namespace app\Doctrine\ORM\Repository;

use Doctrine\ORM\EntityRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;

class OrderRepository extends EntityRepository {
    private static string $alias = "o";

    use PaginatesFromParams;

    public function getOrdersByStatusAscPaginated(int $rowsPerPage, int $pageNumber = 1): LengthAwarePaginator {
        $qb = $this->createQueryBuilder(self::$alias);
        $qb->addSelect("
            CASE o.status
                WHEN 'MEASURING' THEN 1
                WHEN 'ORDERING_MATERIAL' THEN 2
                WHEN 'FABRICATING' THEN 3
                WHEN 'READY_TO_HANDOVER' THEN 4
                WHEN 'INSTALLED' THEN 5
                WHEN 'PICKED_UP' THEN 6
            ELSE 999
            END AS HIDDEN sort_status_col
        ")->orderBy("sort_status_col", "ASC");
        return $this->paginate($qb->getQuery(), $rowsPerPage, $pageNumber);
    }
}