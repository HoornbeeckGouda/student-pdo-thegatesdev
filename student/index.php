<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location:auth.php");
    exit;   
}

header("Location:studenten.php");