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
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFullStudentHTMLTable(): string
    {
        $building_table = "<table id='students'>
        <tr>
            <th>studentnr</th>
            <th>voornaam</th>
            <th>tussenvoegsel</th>
            <th>achternaam</th>
            <th>straat</th>
            <th>postcode</th>
            <th>woonplaats</th>
            <th>email</th>
            <th>klas</th>
            <th>geboortedatum</th>
        </tr>";
        foreach ($this->getFullStudentArray() as $row) {
            $building_table .= "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['voornaam'] . "</td>
                            <td>" . $row['tussenvoegsel'] . "</td>
                            <td>" . $row['achternaam'] . "</td>
                            <td>" . $row['straat'] . "</td>
                            <td>" . $row['postcode'] . "</td>
                            <td>" . $row['woonplaats'] . "</td>
                            <td>" . $row['email'] . "</td>
                            <td>" . $row['klas'] . "</td>
                            <td>" . $row['geboortedatum'] . "</td>
                        </tr>";
        }
        return "$building_table</table>";
    }
}