<?php

namespace Tests\Unit;

use app\Doctrine\ORM\Entity\Client;
use app\Doctrine\ORM\Repository\ClientRepository;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use Tests\DoctrineSetup;

require_once(dirname(__DIR__) . "/DoctrineSetup.php");
require_once("app/Doctrine/ORM/Repository/ClientRepository.php");

class ClientRepositoryTest extends TestCase
{
    private EntityManager $em;
    private ClientRepository $repository;

    public function setUp(): void {
        DoctrineSetup::setUpTestDatabase();
        $this->em = DoctrineSetup::initEntityManager();
        $this->repository = $this->em->getRepository(Client::class);
    }

    /**
     * @test
     */
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }
}