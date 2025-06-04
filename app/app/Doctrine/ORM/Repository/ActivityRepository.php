<?php

declare(strict_types = 1);

namespace app\Doctrine\ORM\Repository;

use app\Doctrine\ORM\Entity\Activity;
use app\Doctrine\ORM\Entity\ActivityType;
use BaseRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use InvalidArgumentException;
use SortOrder;

require_once("BaseRepository.php");

class ActivityRepository extends BaseRepository {
    private static string $alias = "a";

    public function __construct(EntityManagerInterface $em, ClassMetadata $metadata) {
        parent::__construct($em, $metadata, self::$alias);
    }

    /**
     * Inserts a new Activity entity into the database.
     *
     * Persists the provided Activity object if it does not already exist in the database.
     * Throws an InvalidArgumentException if the Activity already has an ID (i.e., is already persisted).
     *
     * @param Activity $activity The Activity entity to insert.
     * @throws InvalidArgumentException If the activity already exists in the database.
     * @return void
     */
    public function insertActivity(Activity $activity) {
        if ($activity->getActivityId() !== null) {
            throw new InvalidArgumentException("The activity provided is already in the database.");
        }
        // Get the entity manager
        $em = $this->getEntityManager();
        // Persist the activity
        $em->persist($activity);
        // Apply the changes to the database
        $em->flush();
    }

    /**
     * Updates an existing Activity entity in the database.
     *
     * Updates the provided Activity object if it already exists in the database.
     * Throws an InvalidArgumentException if the Activity does not have an ID (i.e., is not persisted).
     *
     * @param Activity $activity The Activity entity to update.
     * @throws InvalidArgumentException If the activity does not exist in the database.
     * @return void
     */
    public function updateActivity(Activity $activity) {
        if ($activity->getActivityId() === null) {
            throw new InvalidArgumentException("The activity provided is not in the database.");
        }
        // Get the entity manager
        $em = $this->getEntityManager();
        // Persist if not done so
        $em->persist($activity);
        // Apply the changes to the database
        $em->flush();
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
                $expr->eq("a.activityType", ":type")
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
            return $qb->orderBy("a.logDate", $order->value);
        });
    }

    /**
     * Find only the activities that have been done by the 
     * specified employee.
     * 
     * @param int $employeeId The Id of the employee that did
     * the activities.
     * @return self A clone of the ActivityRepository with the sorting applied.
     */
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

    /**
     * Find only the activities that are related to the specified order.
     * 
     * @param int $orderId The Id of the order that the activities are related to.
     * @return self A clone of the ActivityRepository with the sorting applied.
     */
    public function withOrderId(int $orderId): self {
        return $this->filter(function (QueryBuilder $qb) use ($orderId) {
            // expr
            $expr = $qb->expr();
            $qb = $qb
                ->join("a.order", "o")
                ->andWhere($expr->eq("o.orderId", ":orderId"))
                ->setParameter(":orderId", $orderId);
            return $qb;
        });
    }
}