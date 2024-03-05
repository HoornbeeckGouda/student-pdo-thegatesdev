<?php
session_start();
if (!isset($_SESSION["user"])){
    header("Location:index.php");
    exit;
}

$header_title = "Studenten";
include "parts/header.php";
include "conn/database.php";
include "conn/StudentConnection.php";

$studentConn = new StudentConnection($dbconn);
echo $studentConn->getFullStudentHTMLTable();

include("parts/footer.php");