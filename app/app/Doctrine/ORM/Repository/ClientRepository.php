<?php

declare(strict_types = 1);

namespace app\Doctrine\ORM\Repository;

use Doctrine\ORM\EntityRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;

class ClientRepository extends EntityRepository {
    private static string $alias = "c";

    use PaginatesFromParams;

    public function getAllPaginated(int $rowsPerPage, int $pageNumber = 1): LengthAwarePaginator {
        return $this->paginateAll($rowsPerPage, $pageNumber);
    }

    public function getByNamePaginated(string $name, int $rowsPerPage, int $pageNumber = 1): LengthAwarePaginator {
        // Create the SQL search string
        $searchTarget = "%" . strtolower($name) . "%";

        // Get the QueryBuilder and Expr
        $qb = $this->createQueryBuilder(self::$alias);
        $expr = $qb->expr();

        // Build the Query
        // Use LOWER() SQL function to ignore case
        $qb->where($expr->orX(
                "LOWER(c.firstName) LIKE :target",
                "LOWER(c.lastName) LIKE :target"
            )
        )->setParameter(":target", $searchTarget);
        
        // Return the Paginator
        return $this->paginate($qb->getQuery(), $rowsPerPage, $pageNumber);
    }
}