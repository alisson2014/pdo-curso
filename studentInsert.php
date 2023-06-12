<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once "vendor/autoload.php";

$pdo = ConnectionCreator::createConnection();

$student2 = new Student(null, "WERT", new \DateTimeImmutable("2001-02-08"));
$repository = new PdoStudentRepository($pdo);
$studentInsert = $repository->save($student2);
var_dump($studentInsert);
