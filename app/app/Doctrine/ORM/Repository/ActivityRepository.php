<?php

declare(strict_types = 1);

namespace app\Doctrine\ORM\Repository;

use BaseRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use SortOrder;

require_once("BaseRepository.php");

class ActivityRepository extends BaseRepository {
    private static string $alias = "a";

    public function __construct(EntityManagerInterface $em, ClassMetadata $metadata) {
        parent::__construct($em, $metadata, self::$alias);
    }

    /**
     * Filter activities by type.
     * 
     * @param ActivityType $type The activity type to filter by.
     * @return self A clone of the ActivityRepository with the filtering applied.
     */
    public function filterByType(ActivityType $type): self {
        return $this->filter(function (QueryBuilder $qb) use ($type) {
            $expr = $qb->expr();
            return $qb->andWhere(
                $expr->eq("activity_type", ":type")
            )->setParameter(":type", $type->value);
        });
    }

    /**
     * Sort activities by type.
     * 
     * The sorting applied overrides all previous ordering
     * operations.
     * 
     * @param SortOrder $order The order in which to sort the activities.
     * @return self A clone of the ActivityRepository with the sorting applied.
     */
    public function sortByLogDate(SortOrder $order) {
        return $this->filter(function (QueryBuilder $qb) use ($order) {
            return $qb->orderBy("log_date", $order->value);
        });
    }

    public function withEmployeeId(int $employeeId): self {
        return $this->filter(function (QueryBuilder $qb) use ($employeeId) {
            // expr
            $expr = $qb->expr();
            $qb = $qb
                ->join("a.employee", "e")
                ->andWhere($expr->eq("e.employeeId", ":employeeId"))
                ->setParameter(":employeeId", $employeeId);
            return $qb;
        });
    }
}

enum ActivityType: string {
    case VIEWED = "VIEWED";
    case EDITED = "EDITED";
}