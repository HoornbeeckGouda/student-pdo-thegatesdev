<?php
//STAP 1 - Initialisatie
define('HOST', 'localhost');
define('DATABASE', 'student');
define('USER', 'webuser');
define('PASSWORD','7q06DXjDr1Z3reXK');

//gebruik geen root!!!
//STAP 2 | connection db
try {
    $dbconn=mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    mysqli_set_charset($dbconn, 'utf8');
}
catch (mysqli_sql_exception $e) {
    echo $e->getMessage();
    exit;
}

?>