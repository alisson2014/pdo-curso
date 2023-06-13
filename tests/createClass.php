<?php

use Alura\Pdo\Domain\Model\Student;

include_once "config/index.php";
require_once "vendor/autoload.php";

$conn->beginTransaction();

try {
    $aStudent = new Student(
        null,
        "Nico Steppat",
        new \DateTimeimmutable("1985-05-01")
    );

    $repository->save($aStudent);

    $anotherStudent = new Student(
        null,
        "Sergio Lopes",
        new \DateTimeimmutable("1985-05-01")
    );

    $repository->save($anotherStudent);

    $conn->commit();
} catch (\PDOException $e) {
    echo $e->getMessage();
    $conn->rollBack();
}
