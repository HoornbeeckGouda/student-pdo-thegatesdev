<?php

function queryOrFalse(PDO $pdo, PDOStatement $statement): PDOStatement|false
{
    return $statement->execute() ? $statement : false;
}

class StudentConnection
{
    public static string $student_table_name = "student";
    public static array $editable_student_data = [
        "voornaam", "tussenvoegsel", "achternaam", "straat", "postcode", 
        "woonplaats", "email", "klas", "geboortedatum"
    ];
    private readonly PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    public function getFullStudentArray(): array
    {
        $statement = $this->pdo->query($this->getFullStudentArrayQuery());
        return $statement->fetchAll(PDO::FETCH_BOTH);
    }

    private function getFullStudentArrayQuery(): string{
        return "SELECT 
        id,
        voornaam,
        tussenvoegsel,
        achternaam,
        straat,
        postcode,
        woonplaats,
        email,
        klas,
        geboortedatum
        FROM student
        ORDER BY achternaam, voornaam;";
    }

    public function changeStudent(int $student_id, array $allparams): bool
    {
        if (sizeof($allparams) != sizeof(StudentConnection::$editable_student_data)) throw new Exception("Invalid parameter count, expected " . sizeof($allparams) . " got " . sizeof(StudentConnection::$editable_student_data));
        $statement = $this->pdo->prepare($this->changeStudentQuery());
        return $statement->execute([...array_values($allparams), $student_id]);
    }

    private function changeStudentQuery(): string{
        $table_name = StudentConnection::$student_table_name;
        return "UPDATE $table_name SET 
        voornaam= ?,
        tussenvoegsel= ?,
        achternaam= ?,
        straat= ?,
        postcode= ?,
        woonplaats= ?,
        email= ?,
        klas= ?,
        geboortedatum= ?
        WHERE id = ?";
    }

    public function getStudentRow(int $student_id): array | false{
        $statement = $this->pdo->prepare($this->getStudentRowQuery());
        $statement->execute([$student_id]);
        return $statement->fetch(PDO::FETCH_BOTH);
    }

    private function getStudentRowQuery(): string{
        return "SELECT 
        voornaam,
        tussenvoegsel,
        achternaam,
        straat,
        postcode,
        woonplaats,
        email,
        klas,
        geboortedatum
        FROM student
        WHERE id= ?
        LIMIT 1";
    }
}