<?php

function queryOrFalse(PDO $pdo, PDOStatement $statement): PDOStatement|false
{
    return $statement->execute() ? $statement : false;
}

class StudentConnection
{
    public static string $student_table_name = "student";
    private readonly PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    public function getFullStudentArray(): array
    {
        $statement = $this->pdo->query("SELECT 
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
        return $statement->fetchAll(PDO::FETCH_BOTH);
    }

    public function changeStudent(int $student_id, $voornaam, $tussenvoegsel, $achternaam, $straat, $postcode, $woonplaats, $email, $klas, $geboortedatum): bool
    {
        $statement = $this->pdo->prepare("UPDATE $this->student_table_name SET 
        voornaam= ?,
        tussenvoegsel= ?,
        achternaam= ?,
        straat= ?,
        postcode= ?,
        woonplaats= ?,
        email= ?,
        klas= ?,
        geboortedatum= ?
        WHERE id = ?
        ");
        $params = [$voornaam, $tussenvoegsel, $achternaam, $straat, $postcode, $woonplaats, $email, $klas, $geboortedatum, $student_id];
        return $statement->execute($params);
    }

    public function getStudentRow(int $student_id): array | false{
        $statement = $this->pdo->prepare("SELECT 
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
        WHERE id= ?
        LIMIT 1
        ");
        $statement->execute([$student_id]);
        return $statement->fetch(PDO::FETCH_BOTH);
    }
}