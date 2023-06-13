<?php

use Alura\Pdo\Domain\Model\Student;

include_once "config/index.php";
require_once "vendor/autoload.php";

$student2 = new Student(null, "Jonas", new \DateTimeImmutable("2001-05-12"));
$studentInsert = $repository->save($student2);
var_dump($studentInsert);
