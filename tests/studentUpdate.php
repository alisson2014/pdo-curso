<?php

use Alura\Pdo\Domain\Model\Student;

include_once "config/index.php";
require_once "vendor/autoload.php";

$student = new Student(5, "Irineu", new \DateTimeImmutable("2005-01-12"));
$studentInsert = $repository->save($student);
var_dump($studentInsert);
