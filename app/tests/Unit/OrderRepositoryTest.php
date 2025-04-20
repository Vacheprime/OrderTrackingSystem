<?php

namespace Tests\Unit;

use app\Doctrine\ORM\Entity\Order;
use app\Doctrine\ORM\Repository\OrderRepository;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use Tests\DoctrineSetup;
use FetchesFromPaginator;

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
}