<?php

declare(strict_types = 1);

namespace app\Doctrine\ORM\Repository;

use app\Doctrine\ORM\Entity\Order;
use app\Doctrine\ORM\Entity\Status;
use BaseRepository;
use SortOrder;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Expr;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use InvalidArgumentException;

require_once("BaseRepository.php");

class OrderRepository extends BaseRepository {
    private static string $alias = "o";

    public function __construct(EntityManagerInterface $em, ClassMetadata $metadata) {
        parent::__construct($em, $metadata, self::$alias);
    }

    /**
     * MAYBE REMOVE.
     */
    public function getOrdersByStatusAscPaginated(int $rowsPerPage, int $pageNumber = 1): LengthAwarePaginator {
        return $this->sortByStatus(SortOrder::ASCENDING)->retrievePaginated($rowsPerPage, $pageNumber);
    }

    /**
     * MAYBE REMOVE.
     */
    public function getOrdersByStatusPaginated(Status $status, int $rowsPerPage, int $pageNumber = 1): LengthAwarePaginator {
        return $this->ofStatus($status)->retrievePaginated($rowsPerPage, $pageNumber);
    }

    /**
     * MAYBE REMOVE
     */
    public function searchByNamePaginated(string $name, int $rowsPerPage, int $pageNumber = 1): LengthAwarePaginator {
        return $this->searchByName($name)->sortByCreationDate(SortOrder::ASCENDING)->retrievePaginated($rowsPerPage, $pageNumber);
    }

    /**
     * Insert an order into the database.
     * 
     * @param Order $order The order to insert.
     * @throws InvalidArgumentException Thrown when the order already exists
     * in the database.
     */
    public function insertOrder(Order $order): void {
        if ($order->getOrderId() != null) {
            throw new InvalidArgumentException("The order provided is already in the database!");
        }
        // Get the EntityManager
        $em = $this->getEntityManager();
        // Wrap the insert logic into a transaction.
        // If an error occurs while the reference number is being generated,
        // rollback everything.
        $em->wrapInTransaction(function(EntityManagerInterface $em) use ($order) {
            // Set the current insertion time for the order
            $order->setCreationDateNow();
            // Persist and insert the order
            $em->persist($order);
            $em->flush();
            // Generate the reference number and flush
            $order->assignReferenceNumber();
            $em->flush();
        });
    }

    /**
     * Save the changes made to an order into the database.
     * 
     * @param Order $order The order to update.
     * @throws InvalidArgumentException Thrown when the order has not yet
     * been inserted into the database.
     */
    public function updateOrder(Order $order): void {
        if ($order->getOrderId() == null) {
            throw new InvalidArgumentException("The order must first be inserted in the database!");
        }
        $em = $this->getEntityManager();
        $em->persist($order);
        $em->flush();
    }

    /**
     * Deletes an order if no payments have been made.
     * Also deletes the order's client if the client has 
     * made only this order.
     * 
     * @param Order $order The order to delete.
     */
    public function deleteOrder(Order $order): void {
        // Check if an order has payments
        if ($order->getPayments()->count() != 0) {
            throw new InvalidArgumentException("The order cannot be deleted because it has payments!");
        }
        // Get the EntityManager
        $em = $this->getEntityManager();
        // Check if the client has other orders
        $client = $order->getClient();
        if ($client->getOrders()->count() == 1) {
            // Update association
            $client->removeOrder($order);
            // Schedule removal of client
            $em->remove($client);
        }
        // Schedule removal of order
        $em->remove($order);
        // Remove the order
        $em->flush();
    }

    /**
     * Sorts the current query in ASCENDING or DESCENDING
     * order of its status as specified by the $sortOrder argument.
     * 
     * ASCENDING order will retrieve orders that are currently being worked
     * on. MEASURING first and PICKED_UP last. DESCENDING order will do the
     * opposite.
     * 
     * @param SortOrder $sortOrder The order in which to sort.
     * @return self A clone of the OrderRepository with the sorting applied.
     */
    public function sortByStatus(SortOrder $sortOrder): self {
        return $this->filter(static function(QueryBuilder $qb) use ($sortOrder) {
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
            ")->orderBy("sort_status_col", $sortOrder->value);
        });
    }

    /**
     * Sorts the current query by the order's creation date.
     * 
     * @param SortOrder $sortOrder The order in which to sort.
     * @return self A clone of the OrderRepository with the sorting applied.
     */
    public function sortByCreationDate(SortOrder $sortOrder): self {
        return $this->filter(static function(QueryBuilder $qb) use ($sortOrder) {
            $qb->orderBy("o.creationDate", $sortOrder->value);
        });
    }

    /**
     * Filters the current query to return only orders with the specified status.
     * 
     * @param Status $status The status of the orders to select.
     * @return self A clone of the OrderRepository with the filter applied.
     */
    public function ofStatus(Status $status): self {
        return $this->filter(static function(QueryBuilder $qb) use ($status){
            $qb->andWhere("o.status = :status")->setParameter(":status", $status);
        });
    }

    /**
     * Filters the current query to return only orders 
     * where the client matches the search name.
     * 
     * @param string $name The name of the client to search by. This
     * can be a partial name and not an exact match.
     * @return self A clone of the OrderRepository with the filter applied.
     */
    public function searchByName(string $name): self {
        // Create the SQL search string
        $searchTarget = "%" . strtolower($name) . "%";
        // Apply the search filter
        return $this->filter(static function(QueryBuilder $qb) use ($searchTarget) {
            $expr = $qb->expr();
            $qb->innerJoin("o.client", "c", 
                Expr\Join::WITH,
                $expr->orX(
                    "LOWER(c.firstName) LIKE LOWER(:target)",
                    "LOWER(c.lastName) LIKE LOWER(:target)"
                ))->setParameter(":target", $searchTarget);
        });
    }

    /**
     * Filters the current query to return only orders
     * where the area matches the search area.
     * 
     * @param string $area The area to search. This area can
     * be a partial name. It does not have to be an exact match.
     * @return self A clone of the OrderRepository with the filter applied.
     */
    public function searchByArea(string $area): self {
        // Create the SQL search string
        $searchTarget = "%" . strtolower($area) . "%";
        // Apply the search filter
        return $this->filter(static function(QueryBuilder $qb) use ($searchTarget) {
            $expr = $qb->expr();
            $qb->where(
                $expr->like("LOWER(o.area)", "LOWER(:target)")
            )->setParameter(":target", $searchTarget);
        });
    }

    /**
     * Filters the current query to return only orders with
     * the given client Id.
     * 
     * @param int $id The client Id to filter by.
     * @return self A clone of the OrderRepository with the filter applied.
     */
    public function withClientId(int $id): self {
        return $this->filter(static function(QueryBuilder $qb) use ($id) {
            $expr = $qb->expr();
            $qb->innerJoin("o.client", "c",
                Expr\Join::WITH,
                $expr->eq(
                    "c.clientId",
                    ":id"
                )
            )->setParameter(":id", $id);
        });
    }
}