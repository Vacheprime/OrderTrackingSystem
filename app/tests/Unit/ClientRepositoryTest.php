<?php

namespace Tests\Unit;

use app\Doctrine\ORM\Entity\Client;
use app\Doctrine\ORM\Repository\ClientRepository;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use Tests\DoctrineSetup;
use Closure;
use FetchesFromPaginator;

require_once(dirname(__DIR__) . "/DoctrineSetup.php");
require_once("tests/FetchesFromPaginator.php");
require_once("app/Doctrine/ORM/Repository/ClientRepository.php");

class ClientRepositoryTest extends TestCase
{
    private EntityManager $em;
    private ClientRepository $repository;

    use FetchesFromPaginator;
    /**
     * Setup the test.
     * 
     * Every test reinitializes the database and creates the entity manager.
     */
    public function setUp(): void {
        DoctrineSetup::setUpTestDatabase();
        $this->em = DoctrineSetup::initEntityManager();
        $this->repository = $this->em->getRepository(Client::class);
    }

    /**
     * Testing the getAllPaginated() method of the ClientRepository class.
     * 
     * Here, all client objects should be returned. However, because
     * comparing client objects can become tedious and complicated (due 
     * to the associations), only the first names are compared. 
     * 
     * If all first names appear in the results, then all rows are
     * assumed to be fetched.
     */
    public function testGetAllPaginated(): void
    {
        // Expected first names
        $expectedFirstNames = [
            "John",
            "Emily",
            "Michael",
            "Sofia",
            "Liam",
            "Just"
        ];
        $paginator = $this->repository->getAllPaginated(2, 1);
        // Get all the firstnames of the dataset
        $actualFirstNames = [];
        foreach($paginator->items() as $client) {
            $actualFirstNames[] = $client->getFirstName();
        }
        // The paginator has to be refetched for each page
        while ($paginator->hasMorePages()) {
            $paginator = $this->repository->getAllPaginated(2, $paginator->currentPage() + 1);
            foreach($paginator->items() as $client) {
                $actualFirstNames[] = $client->getFirstName();
            }
        }
        // Assert equals with sorted arrays so that all items appear in the same
        // order if they are equal.
        $this->assertEqualsCanonicalizing($expectedFirstNames, $actualFirstNames);
    }

    /**
     * Testing the getByNamePaginated() method of the ClientRepository class.
     * 
     * Here, all clients with their names matching the
     * search string should be returned. Only first names will
     * be compared.
     * 
     * If the first names match, the client objects are assumed to be
     * equal.
     */
    public function testByNamePaginated() {
        $searchString = "doe";
        $expectedFirstNames = ["John"];
        $clients = self::getAllItemsFromPaginator(10, 1, function($nbrItems, $pageNum) use ($searchString) {
            return $this->repository->getByNamePaginated($searchString, $nbrItems, $pageNum);
        });
        $actualFirstNames = array_map(fn($client) => $client->getFirstName(), $clients);
        $this->assertEqualsCanonicalizing($expectedFirstNames, $actualFirstNames);
    }
}