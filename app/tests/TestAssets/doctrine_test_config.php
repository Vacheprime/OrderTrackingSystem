<?php
// Configuration file for the Doctrine ORM

// Include the autoloader for Doctrine
require_once(dirname(dirname(__DIR__))."/vendor/autoload.php");

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

function initEM(): EntityManager {
    // Define the path that contains all model classes
    $modelClassesPath = [dirname(dirname(__DIR__))."/Doctrine/ORM/Entity"];
    $isDevMode = false;

    // Define the configuration parameters the database connection
    $dbParams = [
        "host" => "127.0.0.1",
        "driver" => "pdo_mysql",
        "user" => "root", // TO BE SECURED
        "password" => "", // TO BE SECURED
        "dbname" => "TESTING_crown_granite_order_db"
    ];

    // Create the configuration
    $config = ORMSetup::createAttributeMetadataConfiguration($modelClassesPath, $isDevMode);
    $config->setAutoGenerateProxyClasses(true);
    $connection = DriverManager::getConnection($dbParams, $config);
    $entityManager = new EntityManager($connection, $config);
    return $entityManager;
}