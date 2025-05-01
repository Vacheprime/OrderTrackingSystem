<?php

declare(strict_types = 1);

namespace app\Doctrine\ORM\Repository;

use app\Doctrine\ORM\Entity\Employee;
use BaseRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use InvalidArgumentException;

require_once("BaseRepository.php");

class EmployeeRepository extends BaseRepository {
    private static string $alias = "e";

    public function __construct(EntityManagerInterface $em, ClassMetadata $metadata) {
        parent::__construct($em, $metadata, self::$alias);
    }

    /**
     * Insert an employee into the database.
     * 
     * @param Employee $employee The employee to insert.
     */
    public function insertEmployee(Employee $employee): void {
        if ($employee->getEmployeeId() != null) {
            throw new InvalidArgumentException("The employee provided is already in the database!");
        }
        // Get the EntityManager
        $em = $this->getEntityManager();
        // Persist and flush
        $em->persist($employee);
        $em->flush($employee);
    }

    /**
     * Save the changes made to an employee into the database.
     * 
     * @param Employee $employee The employee to update.
     * @throws InvalidArgumentException Thrown when the employee has not yet
     * been inserted into the database.
     */
    public function updateEmployee(Employee $employee): void {
        if ($employee->getEmployeeId() == null) {
            throw new InvalidArgumentException("The employee must first be inserted in the database!");
        }
        // Get the EntityManager
        $em = $this->getEntityManager();
        // Persist and flush
        $em->persist($employee);
        $em->flush($employee);
    }

    /**
     * Filter employees by their name.
     * 
     * This method searches the first name and the last name.
     * 
     * @param string $name The name of the employee. It does
     * not have to be an exact match. 
     */
    public function searchByName(string $name): self {
        // Create the SQL search string
        $searchTarget = "%" . strtolower($name) . "%";
        return $this->filter(function (QueryBuilder $qb) use ($searchTarget) {
                $expr = $qb->expr();
                $qb->where($expr->orX(
                    "LOWER(e.firstName) LIKE :target",
                    "LOWER(e.lastName) LIKE :target"
                ))->setParameter(":target", $searchTarget);
            }
        );
    }

    /**
     * Filter employees by their position.
     * 
     * @param string $position.
     * @return self A clone of the EmployeeRepository with the filter applied.
     */
    public function searchByPosition(string $position): self {
        $searchTarget = "%" . strtolower($position) . "%";
        return $this->filter(static function(QueryBuilder $qb) use ($searchTarget) {
            $expr = $qb->expr();
            $qb->where(
                $expr->like("LOWER(e.position)", ":target")
            )->setParameter(":target", $searchTarget);
        });
    }
}