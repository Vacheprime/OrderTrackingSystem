<?php

namespace Tests\Unit;

use app\Doctrine\ORM\Entity\Address;
use app\Doctrine\ORM\Entity\Client;
use app\Doctrine\ORM\Entity\Employee;
use app\Doctrine\ORM\Entity\Order;
use app\Doctrine\ORM\Entity\Payment;
use app\Doctrine\ORM\Entity\PaymentType;
use app\Doctrine\ORM\Entity\Product;
use app\Doctrine\ORM\Entity\Status;
use app\Doctrine\ORM\Repository\OrderRepository;
use app\Doctrine\ORM\Repository\PaymentRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use Tests\DoctrineSetup;
use FetchesFromPaginator;
use InvalidArgumentException;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertTrue;

require_once(dirname(__DIR__) . "/DoctrineSetup.php");
require_once("tests/FetchesFromPaginator.php");
require_once("app/Doctrine/ORM/Repository/PaymentRepository.php");

class PaymentRepositoryTest extends TestCase
{
    private EntityManager $em;
    private PaymentRepository $repository;

    use FetchesFromPaginator;

    /**
     * Setup the test.
     * 
     * Every test reinitializes the database and creates the entity manager.
     */
    public function setUp(): void {
        DoctrineSetup::setUpTestDatabase();
        $this->em = DoctrineSetup::initEntityManager();
        $this->repository = $this->em->getRepository(Payment::class);
    }

    /**
     * Test for the insertPayment method.
     */
    public function testInsertPayment() {
        // Fetch an order
        $orderRepository = $this->em->getRepository(Order::class);
        $order = $orderRepository->find(1);
        // Create a payment
        $payment = new Payment("10.00", PaymentType::INSTALLMENT, "credit", new DateTime("now"), $order);
        // Insert the payment
        $this->repository->insertPayment($payment);
        // Check whether the primary key has been assigned
        assertNotNull($payment->getPaymentId());
    }

    /**
     * Test for the updatePayment method.
     */
    public function testUpdatePayment() {
        // Fetch a payment
        $payment = $this->repository->find(1);
        // Update amount
        $payment->setAmount("10.0");
        $this->repository->updatePayment($payment);

        // Get another EntityManager and refetch the payment.
        $em = DoctrineSetup::initEntityManager();
        $newRepository = $em->getRepository(Payment::class);
        // Refetch and check
        $payment2 = $newRepository->find(1);

        assertTrue(bccomp("10.0", $payment2->getAmount()) === 0);
    }
}