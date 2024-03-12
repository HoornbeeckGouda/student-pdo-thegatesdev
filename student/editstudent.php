<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location:index.php");
    exit;
}

if (!isset($_GET["id"])){
    echo "<h1>Missing student ID</h1>";
    header( "refresh:1;url=studenten.php" );
    exit;
}

$header_title = "Studenten";
include "parts/header.php";
include "conn/database.php";
include "classes/StudentConnection.php";
$studentConn = new StudentConnection($dbconn);

$student_id = $_GET["id"];
$student_values = $studentConn->getStudentRow($student_id);

if (isset($_POST["submit"])){
    $newarray = [];
    foreach (StudentConnection::$editable_student_data as $key){
        if (isset($_POST[$key]) && $_POST[$key] != ''){
            $student_values[$key] = $newarray[$key] = $_POST[$key];
        }else{
            $newarray[$key] = $student_values[$key];
        }
    }
    $studentConn->changeStudent($student_id, $newarray);
}

?>

<form method="POST">
    <table class="datatable">
        <tr>
            <th>Field</th>
            <th>Value</th>
            <th>Edit</th>
        </tr>
        <tr>
            <td>ID</td>
            <td><?php echo $student_id ?></td>
            <td>-</td>
        </tr>
        <?php
        foreach (StudentConnection::$editable_student_data as $key){
            echo "
                <tr>
                    <td>$key</td>
                    <td>{$student_values[$key]}</td>
                    <td><input type='text' name='$key'></td>
                </tr>";
        }
        ?>
        <tr>
            <td><a href='studenten.php'>Cancel</a></td>
            <td colspan="2"><input type='submit' name="submit" value='Submit'></td>
        </tr>
    </table>
</form>

