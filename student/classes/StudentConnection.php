<?php

class StudentConnection
{
    public static string $student_table_name = "student";
    public static array $editable_student_data = [
        "voornaam", "tussenvoegsel", "achternaam", "straat", "postcode", 
        "woonplaats", "email", "klas", "geboortedatum"
    ];
    private readonly PDO $pdo;

    private PDOStatement $statChangeStudent, 
    $statGetStudentRow, 
    $statGetFullStudentArray;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    public function getFullStudentArray(): array | false
    {
        $statement = $this->getFullStudentArrayQuery();
        if ($statement === false) return false;

        if ($statement->execute() == false) return false;
        return $statement->fetchAll(PDO::FETCH_BOTH);
    }
    
    public function changeStudent(int $student_id, array $allparams): bool
    {
        if (sizeof($allparams) != sizeof(StudentConnection::$editable_student_data)) throw new Exception("Invalid parameter count, expected " . sizeof($allparams) . " got " . sizeof(StudentConnection::$editable_student_data));
        $statement = $this->changeStudentQuery();
        if ($statement === false) return false;

        return $statement->execute([...array_values($allparams), $student_id]);
    }

    public function getStudentRow(int $student_id): array | false{
        $statement = $this->getStudentRowQuery();
        if ($statement === false) return false;

        if ($statement->execute([$student_id]) === false) return false;
        return $statement->fetch(PDO::FETCH_BOTH);
    }
    

    private function getFullStudentArrayQuery(): PDOStatement | false{
        return $this->statGetFullStudentArray ??= 
        $this->pdo->prepare("SELECT 
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
        ORDER BY achternaam, voornaam;");
    }

    private function changeStudentQuery(): PDOStatement | false{
        $table_name = StudentConnection::$student_table_name;
        return $this->statChangeStudent ??= 
        $this->pdo->prepare("UPDATE $table_name SET 
        voornaam= ?,
        tussenvoegsel= ?,
        achternaam= ?,
        straat= ?,
        postcode= ?,
        woonplaats= ?,
        email= ?,
        klas= ?,
        geboortedatum= ?
        WHERE id = ?");
    }

    private function getStudentRowQuery(): PDOStatement | false{
        return $this->statGetStudentRow ??=
        $this->pdo->prepare("SELECT 
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
        LIMIT 1");
    }
}