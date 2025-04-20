<?php

declare(strict_types = 1);

namespace app\Doctrine\ORM\Repository;

use BaseRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

require_once("BaseRepository.php");

class ClientRepository extends BaseRepository {
    private static string $alias = "c";

    public function __construct(EntityManagerInterface $em, ClassMetadata $metadata) {
        parent::__construct($em, $metadata, self::$alias);
    }

    public function getAllPaginated(int $rowsPerPage, int $pageNumber = 1): LengthAwarePaginator {
        return parent::paginateAll($rowsPerPage, $pageNumber);
    }

    public function getByNamePaginated(string $name, int $rowsPerPage, int $pageNumber = 1): LengthAwarePaginator {
        return $this->filterByName($name)->retrievePaginated($rowsPerPage, $pageNumber);
    }

    public function filterByName(string $name): self {
        // Create the SQL search string
        $searchTarget = "%" . strtolower($name) . "%";
        return $this->filter(function (QueryBuilder $qb) use ($searchTarget) {
                $expr = $qb->expr();
                $qb->where($expr->orX(
                    "LOWER(c.firstName) LIKE :target",
                    "LOWER(c.lastName) LIKE :target"
                ))->setParameter(":target", $searchTarget);
            }
        );
    }
}