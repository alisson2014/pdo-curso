<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once "vendor/autoload.php";

$conn = ConnectionCreator::createConnection();
$repository = new PdoStudentRepository($conn);
