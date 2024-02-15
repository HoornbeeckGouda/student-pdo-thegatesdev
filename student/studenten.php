<?php
session_start();
if (!isset($_SESSION["user"])){
    header("Location:index.php");
    exit;
}

$header_title = "Studenten";
include("parts/header.php");
include("conn/database.php");

$table_header = '<table id="students">
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
                    </tr>';
$qry_student = "SELECT 
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
$prepared_query = $dbconn->prepare($qry_student);
// gegevens query ophalen uit db student
try {
    if (!$prepared_query->execute()) throw new PDOException();
    $prepared_query->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<h1>Query failed</h1>";
    exit;
}

$contentTable = "";
foreach ($prepared_query as $row) {
    $contentTable .= "<tr>
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

$table_student = $table_header . $contentTable . "</table>";
echo $table_student;

include("parts/footer.php");