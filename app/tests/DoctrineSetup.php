<?php

declare(strict_types = 1);

namespace Tests;

use Doctrine\ORM\EntityManager;

class DoctrineSetup {
    public static string $testDBUserName = "root";
    public static string $password = "12345678";
    public static string $dbName = "TESTING_crown_granite_order_db";

    public static function setUpTestDatabase(): void {
        $dbInitFilePath = "tests/TestAssets/test_db_init.sql";
        $cmd = "mysql -u " . self::$testDBUserName. " -p" . self::$password . " " . self::$dbName . " < $dbInitFilePath -h 127.0.0.1";
        $output = shell_exec($cmd);
        echo $output;
    }

    public static function initEntityManager(): EntityManager {
        require_once("TestAssets/doctrine_test_config.php");
        return initEM();
    }
}