<?php

namespace Tests\Unit;

use app\Doctrine\ORM\Entity\Activity;
use app\Doctrine\ORM\Entity\Client;
use app\Doctrine\ORM\Repository\ActivityRepository;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use Tests\DoctrineSetup;
use Closure;
use FetchesFromPaginator;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertEqualsCanonicalizing;
use function PHPUnit\Framework\assertTrue;

require_once(dirname(__DIR__) . "/DoctrineSetup.php");
require_once("tests/FetchesFromPaginator.php");
require_once("app/Doctrine/ORM/Repository/ActivityRepository.php");

class ActivityRepositoryTest extends TestCase
{
    private EntityManager $em;
    private ActivityRepository $repository;

    use FetchesFromPaginator;
    
    /**
     * Setup the test.
     * 
     * Every test reinitializes the database and creates the entity manager.
     */
    public function setUp(): void {
        DoctrineSetup::setUpTestDatabase();
        $this->em = DoctrineSetup::initEntityManager();
        $this->repository = $this->em->getRepository(Activity::class);
    }

    /**
     * Test for the withEmployeeId method.
     */
    public function testWithEmployeeId() {
        $expectedIds = [
            1,
            7
        ];
        $activities = $this->repository->withEmployeeId(3)->retrieve();
        $actualIds = array_map(fn($activity) => $activity->getActivityId(), $activities);
        assertEqualsCanonicalizing($expectedIds, $actualIds);
    }
}