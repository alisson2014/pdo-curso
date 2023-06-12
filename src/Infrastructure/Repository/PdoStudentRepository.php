<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Model\Phone;
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
        $studentDataList = $stmt->fetchAll();
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
        $insertSql = "INSERT INTO students VALUES (NULL, ?, ?);";
        $stmt = $this->connection->prepare($insertSql);

        $bindValues = [
            $student->name(),
            $student->birthDate()->format("Y-m-d")
        ];

        $success = $stmt->execute($bindValues);

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

    public function studentsWithPhones(): array
    {
        $sqlQuery = "SELECT students.id,
                            students.name,
                            students.birth_date,
                            phones.id AS phone_id,
                            phones.area_code,
                            phones.number
                     FROM students
                     JOIN phones ON students.id = phones.student_id;";
        $stmt = $this->connection->query($sqlQuery);
        $result = $stmt->fetchAll();
        $studentList = [];

        foreach ($result as $row) {
            if (!array_key_exists($row['id'], $studentList)) {
                $studentList[$row['id']] = new Student(
                    $row['id'],
                    $row['name'],
                    new \DateTimeImmutable($row['birth_date'])
                );
            }
            $phone = new Phone($row['phone_id'], $row['area_code'], $row['number']);
            $studentList[$row['id']]->addPhone($phone);
        }

        return $studentList;
    }
}
