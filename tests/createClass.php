<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once 'vendor/autoload.php';

$conn = ConnectionCreator::createConnection();
$studentRepository = new PdoStudentRepository($conn);

$conn->beginTransaction();

try {
    $aStudent = new Student(
        null,
        'Nico Steppat',
        new \DateTimeimmutable('1985-05-01')
    );

    $studentRepository->save($aStudent);

    $anotherStudent = new Student(
        null,
        'Sergio Lopes',
        new \DateTimeimmutable('1985-05-01')
    );

    $studentRepository->save($anotherStudent);

    $conn->commit();
} catch (\PDOException $e) {
    echo $e->getMessage();
    $conn->rollBack();
}
