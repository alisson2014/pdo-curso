<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once "vendor/autoload.php";

$pdo = ConnectionCreator::createConnection();

$student = new Student(2, "Joelsom", new \DateTimeImmutable("2001-07-08"));
$repository = new PdoStudentRepository($pdo);
$studentInsert = $repository->save($student);
var_dump($studentInsert);
