<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Repository\StudentRepository;
use PDO;

class PdoStudentRepository implements StudentRepository
{
    /**
     * @var PDO $connection
     */
    private PDO $connection;
    public function __construct(PDO $pdo)
    {
        $this->connection = $pdo;
    }
    public function allStudents(): array
    {
        $sqlQuery = "SELECT * FROM students;";
        $stmt = $this->connection->query($sqlQuery);

        return $this->hydrateStudentList($stmt);
    }
    public function studentsBirthAt(\DateTimeInterface $birthDate): array
    {
        $sqlQuery = "SELECT * FROM students WHERE birth_date = ?;";
        $stmt = $this->connection->prepare($sqlQuery);
        $stmt->bindValue(1, $birthDate->format("Y-m-d"), PDO::PARAM_STR);
        $stmt->execute();

        return $this->hydrateStudentList($stmt);
    }
    private function hydrateStudentList(\PDOStatement $stmt): array
    {
        $studentDataList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $studentList = [];

        foreach ($studentDataList as $studentData) {
            $id = $studentData["id"];
            $name = $studentData["name"];
            $birth_date =  new \DateTimeImmutable($studentData["birth_date"]);

            $studentList[] = new Student($id, $name, $birth_date);
        }

        return $studentList;
    }
    public function save(Student $student): bool
    {
        if ($student->id() === null) {
            return $this->insert($student);
        }

        return $this->update($student);
    }
    private function insert(Student $student): bool
    {
        $insertSql = "INSERT INTO students VALUES (NULL, :name, :birth_date);";
        $stmt = $this->connection->prepare($insertSql);

        $success = $stmt->execute([
            ":name" => $student->name(),
            ":birth_date" => $student->birthDate()->format("Y-m-d")
        ]);

        if ($success) {
            $student->defineId($this->connection->lastInsertId());
        }

        return $success;
    }
    private function update(Student $student): bool
    {
        $updateQuery = "UPDATE students SET name = :name, birth_date = :birth_date WHERE id = :id;";
        $stmt = $this->connection->prepare($updateQuery);
        $stmt->bindValue(":name", $student->name(), PDO::PARAM_STR);
        $stmt->bindValue(":birth_date", $student->birthDate()->format('Y-m-d'), PDO::PARAM_STR);
        $stmt->bindValue(":id", $student->id(), PDO::PARAM_INT);

        return $stmt->execute();
    }
    public function delete(int $id): bool
    {
        $stmt = $this->connection->prepare("DELETE FROM students WHERE id = ?;");
        $stmt->bindValue(1, $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}