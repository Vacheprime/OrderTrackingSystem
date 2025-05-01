<?php

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;


/**
 * BaseRepository class is used as a superclass
 * for all repositories used in this project.
 * 
 * It contains methods for applying filters, counting, and retrieving
 * results.
 * 
 * Querying using the BaseRepository and its subclasses is similar to using 
 * Java streams, or C# LINQ.
 * 
 * For example, to get all orders, in an array, of a certain status ordered
 * by the creation date in descending order (oldest), you would do, using a
 * OrderRepository instance:
 *   
 * $orders = $orderRepository->ofStatus(Status::MEASURING)->sortByCreationDate(SortOrder::DESCENDING)->retrieve();
 */
class BaseRepository extends EntityRepository {

    use PaginatesFromParams;

    private QueryBuilder $qb;

    public function __construct(EntityManagerInterface $em, ClassMetadata $metadata, string $alias) {
        parent::__construct($em, $metadata);
        $this->qb = $this->createQueryBuilder($alias);
    }

    /**
     * Get all results of the current query as
     * a LengthAwarePaginator.
     */
    public function retrievePaginated(int $nbrOfRows, int $pageNumber): LengthAwarePaginator {
        return $this->paginate($this->qb->getQuery(), $nbrOfRows, $pageNumber);
    }

    /**
     * Get all results of the current query as an array
     * 
     * @return mixed The result of the underlying query.
     */
    public function retrieve(): mixed {
        return $this->qb->getQuery()->getResult();
    }

    /**
     * Apply a given closure to the current query.
     */
    public function filter(Closure $filter): self {
        // Clone the repository
        $clonedRepo = clone $this;
        // Apply the filter on the cloned query builder
        $filter($clonedRepo->qb);
        // Returned the cloned repository
        return $clonedRepo;
    }

    /**
     * Count the number of results in the current query.
     * This method makes use of the Doctrine Paginator's count method.
     */
    public function countFromCurrentQuery(): int {
        return (new Paginator($this->qb->getQuery()))->count();
    }

    public function getQueryBuilder(): QueryBuilder {
        return clone $this->qb;
    }

    /**
     * Clone the QueryBuilder.
     */
    public function __clone() {
        $this->qb = clone $this->qb;
    }
}

/**
 * Enum SortOrder represents the sorting order.
 */
enum SortOrder: string {
    case DESCENDING = "DESC";
    case ASCENDING = "ASC";
}