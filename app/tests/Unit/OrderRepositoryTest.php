<?php

namespace Tests\Unit;

use app\Doctrine\ORM\Entity\Address;
use app\Doctrine\ORM\Entity\Client;
use app\Doctrine\ORM\Entity\Employee;
use app\Doctrine\ORM\Entity\Order;
use app\Doctrine\ORM\Entity\Product;
use app\Doctrine\ORM\Entity\Status;
use app\Doctrine\ORM\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use Tests\DoctrineSetup;
use FetchesFromPaginator;
use InvalidArgumentException;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertTrue;

require_once(dirname(__DIR__) . "/DoctrineSetup.php");
require_once("tests/FetchesFromPaginator.php");
require_once("app/Doctrine/ORM/Repository/OrderRepository.php");

class OrderRepositoryTest extends TestCase
{
    private EntityManager $em;
    private OrderRepository $repository;

    use FetchesFromPaginator;

    /**
     * Setup the test.
     * 
     * Every test reinitializes the database and creates the entity manager.
     */
    public function setUp(): void {
        DoctrineSetup::setUpTestDatabase();
        $this->em = DoctrineSetup::initEntityManager();
        $this->repository = $this->em->getRepository(Order::class);
    }

    /**
     * Test for the getOrdersByStatusAscPaginated() method.
     * 
     * Only the statuses of the orders received are checked.
     * If the order matches, then the orders are assumed to be
     * fully populated and in the right order.
     */
    public function testGetOrdersByStatusAscPaginated() {
        // List the ordering of the expected order statuses
        $expectedStatuses = [
            "MEASURING",
            "MEASURING",
            "MEASURING",
            "ORDERING_MATERIAL",
            "ORDERING_MATERIAL",
            "FABRICATING",
            "FABRICATING",
            "READY_TO_HANDOVER",
            "INSTALLED",
            "INSTALLED",
            "PICKED_UP"
        ];
        // Fetch orders from test data
        $orders = self::getAllItemsFromPaginator(3, 1, function (int $rows, int $page) {
            return $this->repository->getOrdersByStatusAscPaginated($rows, $page);
        });

        // Compare the ordering
        $actualStatuses = array_map(fn($order) => $order->getStatus()->value, $orders);
        $this->assertEquals($expectedStatuses, $actualStatuses);
    }

    /**
     * Test for the searchByNamePaginated() method.
     * 
     * 
     */
    public function testSearchByNamePaginated() {
        // The ordering of the expected order Ids
        $expectedOrderIds = [6, 1];
        // Fetch the orders
        $orders = self::getAllItemsFromPaginator(3, 1, function (int $rows, int $page) {
            return $this->repository->searchByNamePaginated("doe", $rows, $page);
        });
        // Compare the order Ids and the ordering
        $actualIds = array_map(fn($order) => $order->getOrderId(), $orders);
        $this->assertEquals($expectedOrderIds, $actualIds);
    }

    /**
     * Test the insertOrder method.
     */
    public function testInsertOrder() {
        $clientRepository = $this->em->getRepository(Client::class);
        $employeeRepository = $this->em->getRepository(Employee::class);
        // Get client and employee with Ids 1
        $client = $clientRepository->find(1);
        $employee = $employeeRepository->find(1);

        // Create the order product
        $product = new Product("Marble", 56, 56, 3, "100", null, "Big Sink", "Just some product", "");
        
        // Create the order
        $order = new Order("1000.00", Status::MEASURING, "73845", null, null, null, $client, $employee, new ArrayCollection(), $product);

        // Insert the order
        $this->repository->insertOrder($order);

        // Assert that the order has been inserted with a reference number
        assertNotNull($order->getOrderId());
        assertNotNull($order->getReferenceNumber());
    }

    /**
     * Test the updateOrder method.
     */
    public function testUpdateOrder() {
        // Fetch the order.
        $order = $this->repository->find(1);
        // Update locally.
        $order->setStatus(Status::PICKED_UP);
        // Update to database.
        $this->repository->updateOrder($order);
        // Assert changes were made.
        $order = $this->repository->find(1);
        assertEquals(Status::PICKED_UP, $order->getStatus());
    }

    /**
     * Test the deleteOrder method.
     */
    public function testDeleteOrder() {
        // Get the client repository
        $clientRepository = $this->em->getRepository(Client::class);
        $addressRepository = $this->em->getRepository(Address::class);

        // Fetch the eleventh order
        $order = $this->repository->find(11);
        $client = $order->getClient();
        
        $this->repository->deleteOrder($order);

        // Attempt to fetch the order, its client, and its address
        $order = $this->repository->find(11);
        $client = $clientRepository->find(6);
        $addr = $addressRepository->find(11);

        // Assert that the order, the client, and the client's address no longer exist
        assertNull($order);
        assertNull($client);
        assertNull($addr);
    }

    /**
     * Test the deleteOrder method with an order that
     * contains payments.
     */
    public function testDeleteOrderWithPayment() {
        // Fetch an order
        $order = $this->repository->find(5);

        // Set expected exception and message 
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The order cannot be deleted because it has payments!");

        // Attempt to delete
        $this->repository->deleteOrder($order);
    }

    /**
     * Test the findByReference method.
     */
    public function testFindByReference() {
        $reference = "ORD-1001";
        $expectedId = 1;
        $order = $this->repository->findByReferenceNumber($reference);
        assertEquals($expectedId, $order->getOrderId());
    }

    public function testFindByReferenceInvalid() {
        $reference = "sdasd";
        $order = $this->repository->findByReferenceNumber($reference);
        assertNull($order);
    }
}