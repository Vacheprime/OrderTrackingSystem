<?php

declare(strict_types = 1);

namespace app\Doctrine\ORM\Repository;

use app\Doctrine\ORM\Entity\Order;
use app\Doctrine\ORM\Entity\Status;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
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

    public function getOrdersByStatusPaginated(Status $status, int $rowsPerPage, int $pageNumber = 1): LengthAwarePaginator {
        $qb = $this->createQueryBuilder(self::$alias);
        $qb->where("o.status = :status")
            ->setParameter(":status", $status->value);
        return $this->paginate($qb->getQuery(), $rowsPerPage, $pageNumber);
    }

    public function searchByNamePaginated(string $name, $rowsPerPage, int $pageNumber = 1, ?Status $status = null, OrderFilter $filter = OrderFilter::NONE) {
        // Create the SQL search string
        $searchTarget = "%" . strtolower($name) . "%";

        // Create the QueryBuilder and Expr
        $qb = $this->createQueryBuilder(self::$alias);
        $expr = $qb->expr();
        
        // Build the search query
        $qb->innerJoin("o.client", "c", 
            Expr\Join::WITH,
            $expr->orX(
                "LOWER(c.firstName) LIKE :target",
                "LOWER(c.lastName) LIKE :target"
            )
        )->setParameter(":target", $searchTarget);
        
        // Select only orders with the given status
        if (!$status == null) {
            $this->ofStatus($qb, $status);
        }
        
        // Order the results
        $this->filterBy($qb, $filter);

        // Paginate the results
        return $this->paginate($qb->getQuery(), $rowsPerPage, $pageNumber);
    }

    public function searchByAreaPaginated() {
        
    }

    public function searchByOrderIdPaginated() {

    }

    public function searchByClientIdPaginated() {

    }

    private function filterBy(QueryBuilder $qb, OrderFilter $filter): QueryBuilder {
        if ($filter == OrderFilter::NONE) return $qb;
        switch ($filter) {
            case OrderFilter::NEWEST:
                $qb->orderBy("o.creationDate", "DESC");
                break;
            case OrderFilter::OLDEST:
                $qb->orderBy("o.creationDate", "ASC");
                break;
        }
        return $qb;
    }

    private function ofStatus(QueryBuilder $qb, Status $status): QueryBuilder {
        return $qb->andWhere("o.status = :status")->setParameter(":status", $status->value);
    }
}

/**
 * Enum OrderFilter represents the different filters
 * that can be used when fetching orders.
 */
enum OrderFilter {
    case NONE;
    case NEWEST;
    case OLDEST;
}