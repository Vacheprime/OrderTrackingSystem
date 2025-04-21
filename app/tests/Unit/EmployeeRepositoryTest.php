<?php

namespace Tests\Unit;

use app\Doctrine\ORM\Entity\Account;
use app\Doctrine\ORM\Entity\Address;
use app\Doctrine\ORM\Entity\Employee;
use app\Doctrine\ORM\Repository\EmployeeRepository;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use Tests\DoctrineSetup;
use FetchesFromPaginator;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertEqualsCanonicalizing;
use function PHPUnit\Framework\assertNotNull;

require_once(dirname(__DIR__) . "/DoctrineSetup.php");
require_once("tests/FetchesFromPaginator.php");
require_once("app/Doctrine/ORM/Repository/EmployeeRepository.php");

class EmployeeRepositoryTest extends TestCase {

    private EntityManager $em;
    private EmployeeRepository $repository;

    use FetchesFromPaginator;

    /**
     * Setup the test.
     * 
     * Every test reinitializes the database and creates the entity manager.
     */
    public function setUp(): void {
        DoctrineSetup::setUpTestDatabase();
        $this->em = DoctrineSetup::initEntityManager();
        $this->repository = $this->em->getRepository(Employee::class);
    }

    /**
     * Test the insertEmployee method.
     */
    public function testInsertEmployee() {
        // Create a new address and a new employee
        $addr = new Address("NOWHERE", null, "J8B 2K9", "SOME AREA");
        $acc = new Account("john@gmail.com", "askjdgh28347A!", false, false, false);
        $employee = new Employee("JOHN", "MAC", "+1 (555) 999-0283", $addr, "JM", "JANITOR", $acc);
        // Insert into the db
        $this->repository->insertEmployee($employee);
        // Assert
        assertNotNull($employee->getEmployeeId());
    }

    /**
     * Test the updateEmployee method.
     */
    public function testUpdateEmployee() {
        // Fetch employee 1.
        $employee = $this->repository->find(1);
        // Modify his first name
        $employee->setFirstName("SOME OTHER FS");
        // Update the first name
        $this->repository->updateEmployee($employee);
        // Fetch the client again
        $employee = $this->repository->find(1);
        // Assert
        assertEquals("SOME OTHER FS", $employee->getFirstName());
    }

    /**
     * Test the searchByName method.
     */
    public function testSearchByName() {
        // Setup
        $expectedIds = [1];
        $searchString = "doe";
        // Fetch the employees
        $employees = $this->repository->searchByName($searchString)->retrieve();
        // Map to ids
        $actualIds = array_map(fn($emp) => $emp->getEmployeeId(), $employees);
        // Assert
        assertEqualsCanonicalizing($expectedIds, $actualIds);
    }

    /**
     * Test the searchByPosition method.
     */
    public function testSearchByPosition() {
        // Setup
        $expectedIds = [2, 5];
        $searchString = "al";
        // Fetch the employees
        $employees = $this->repository->searchByPosition($searchString)->retrieve();
        // Map to ids
        $actualIds = array_map(fn($emp) => $emp->getEmployeeId(), $employees);
        // Assert
        assertEqualsCanonicalizing($expectedIds, $actualIds);
    }
}