<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location:index.php");
    exit;
}

$header_title = "Studenten";
include "parts/header.php";
include "conn/database.php";
include "classes/StudentConnection.php";
$studentConn = new StudentConnection($dbconn);

$building_table = "<table class='datatable'>
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
            <th>action</th>
        </tr>";
foreach ($studentConn->getFullStudentArray() as $row) {
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
                            <td><a href='editstudent.php?id={$row['id']}'>EDIT</a></td>
                        </tr>";
}
echo "$building_table</table>";

include "parts/footer.php";