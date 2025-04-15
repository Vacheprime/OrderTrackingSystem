<?php
// Configuration file for the Doctrine ORM

// Include the autoloader for Doctrine
require_once(dirname(dirname(__DIR__))."/vendor/autoload.php");

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

// Define the path that contains all model classes
$modelClassesPath = [dirname(dirname(__DIR__))."/models"];
$isDevMode = false;

// Define the configuration parameters the database connection
$dbParams = [
    "host" => "127.0.0.1",
    "driver" => "pdo_mysql",
    "user" => "root", // TO BE SECURED
    "password" => "12345678", // TO BE SECURED
    "dbname" => "crown_granite_order_db"
];

// Create the configuration
$config = ORMSetup::createAttributeMetadataConfiguration($modelClassesPath, $isDevMode);
$config->setAutoGenerateProxyClasses(true);
$connection = DriverManager::getConnection($dbParams, $config);
$entityManager = new EntityManager($connection, $config);