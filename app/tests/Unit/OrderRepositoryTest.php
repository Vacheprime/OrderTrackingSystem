<?php

namespace Tests\Unit;

use app\Doctrine\ORM\Entity\Order;
use app\Doctrine\ORM\Repository\OrderRepository;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use Tests\DoctrineSetup;
use Closure;
use FetchesFromPaginator;

use function PHPUnit\Framework\assertEquals;

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

    public function testGetOrdersByStatusAscPaginated() {
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
        $orders = self::getAllItemsFromPaginator(3, 1, function (int $rows, int $page) {
            return $this->repository->getOrdersByStatusAscPaginated($rows, $page);
        });
        foreach($orders as $ord) {
            if (gettype($ord) == "array") {
                var_dump($ord);
            }
            echo gettype($ord);
        }
        $actualStatuses = array_map(fn($order) => $order->getStatus()->value, $orders);
        $this->assertEquals($expectedStatuses, $actualStatuses);
    }
}