<?php

declare(strict_types = 1);

namespace app\Doctrine\ORM\Repository;

use app\Doctrine\ORM\Entity\Client;
use BaseRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use InvalidArgumentException;

require_once("BaseRepository.php");

class ClientRepository extends BaseRepository {
    private static string $alias = "c";

    public function __construct(EntityManagerInterface $em, ClassMetadata $metadata) {
        parent::__construct($em, $metadata, self::$alias);
    }

    public function getAllPaginated(int $rowsPerPage, int $pageNumber = 1): LengthAwarePaginator {
        return parent::paginateAll($rowsPerPage, $pageNumber);
    }

    public function getByNamePaginated(string $name, int $rowsPerPage, int $pageNumber = 1): LengthAwarePaginator {
        return $this->searchByName($name)->retrievePaginated($rowsPerPage, $pageNumber);
    }

    /**
     * Save the changes made to a client into the database.
     * 
     * @param Client $client The client to update.
     * @throws InvalidArgumentException Thrown when the client has not yet
     * been inserted into the database.
     */
    public function updateClient(Client $client): void {
        if ($client->getClientId() == null) {
            throw new InvalidArgumentException("The client must first be inserted in the database!");
        }
        // Get the EntityManager
        $em = $this->getEntityManager();
        // Persist and flush
        $em->persist($client);
        $em->flush($client);
    }

    /**
     * Filter clients by their name.
     * 
     * This method searches the first name and the last name.
     * 
     * @param string $name The name of the client. It does
     * not have to be an exact match. 
     */
    public function searchByName(string $name): self {
        // Create the SQL search string
        $searchTarget = "%" . strtolower($name) . "%";
        return $this->filter(function (QueryBuilder $qb) use ($searchTarget) {
                $expr = $qb->expr();
                $qb->where($expr->orX(
                    "LOWER(c.firstName) LIKE :target",
                    "LOWER(c.lastName) LIKE :target"
                ))->setParameter(":target", $searchTarget);
            }
        );
    }

    /**
     * Filter clients by their area.
     * 
     * This method searches clients based on the area they live at.
     * 
     * @param string $area The area of the client. It does not have to be
     * an exact match.
     */
    public function searchByArea(string $area): self {
        // Create the SQL search string
        $searchTarget = "%" . strtolower($area) . "%";
        return $this->filter(function (QueryBuilder $qb) use ($searchTarget) {
            $expr = $qb->expr();
            $qb->join("c.address", "a")
                ->where(
                    $expr->like("LOWER(a.area)", ":target")
                )->setParameter(":target", $searchTarget);
        });
    }
}