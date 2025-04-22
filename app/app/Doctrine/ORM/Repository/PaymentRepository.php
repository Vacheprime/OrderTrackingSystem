<?php

declare(strict_types = 1);

namespace app\Doctrine\ORM\Repository;

use app\Doctrine\ORM\Entity\Payment;
use BaseRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use InvalidArgumentException;

require_once("BaseRepository.php");

class PaymentRepository extends BaseRepository {
    private static string $alias = "p";

    public function __construct(EntityManagerInterface $em, ClassMetadata $metadata) {
        parent::__construct($em, $metadata, self::$alias);
    }

    /**
     * Insert a payment into the database.
     * 
     * @param Payment $payment The payment to insert.
     * @throws InvalidArgumentException Thrown when the payment already exists
     * in the database.
     */
    public function insertPayment(Payment $payment) {
        if ($payment->getPaymentId() != null) {
            throw new InvalidArgumentException("The payment provided is already in the database!");
        }
        // Get the EntityManager
        $em = $this->getEntityManager();
        // Persist
        $em->persist($payment);
        // Flush
        $em->flush();
    }

    /**
     * Insert a payment into the database.
     * 
     * @param Payment $payment The payment to update.
     * @throws InvalidArgumentException Thrown when the payment already exists
     * in the database.
     */
    public function updatePayment(Payment $payment) {
        if ($payment->getPaymentId() == null) {
            throw new InvalidArgumentException("The payment must first be inserted in the database!");
        }
        // Get the EntityManager
        $em = $this->getEntityManager();
        // Persist
        $em->persist($payment);
        // Flush
        $em->flush();
    }

    /**
     * Delete a payment from the database.
     * 
     * @param Payment $payment The payment to delete.
     * @throws InvalidArgumentException Thrown when the payment does not 
     * exist in the database.
     */
    public function deletePayment(Payment $payment) {
        if ($payment->getPaymentId() == null) {
            throw new InvalidArgumentException("The payment does not exist in the database!");
        }
        // Remove associations
        $payment->getOrder()->getPayments()->removeElement($payment);
        $payment->removeOrder();
        // Get the EntityManager
        $em = $this->getEntityManager();
        // Remove
        $em->remove($payment);
        // Flush
        $em->flush();
    }

    /**
     * Filters the current query to return only payments with
     * the given order Id.
     * 
     * @param int $id The order Id to filter by.
     * @return self A clone of the PaymentRepository with the filter applied.
     */
    public function withOrderId(int $orderId): self {
        return $this->filter(static function (QueryBuilder $qb) use ($orderId) {
            $expr = $qb->expr();
            $qb->innerJoin("p.order", "o",
                Expr\Join::WITH,
                $expr->eq(
                    "o.orderId",
                    ":id"
                )
            )->setParameter(":id", $orderId);
        });
    }
}