<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location:index.php");
    exit;   
}

if (isset($_POST["login"])) {
    include("conn/database.php");
    if (!$dbconn){
        $page_msg = "Kon niet verbinden!";
    }else{
        $input_username = $_POST["username"] ?? "";
        $input_passsword = $_POST["password"] ?? "";
        $sth = $dbconn->prepare("SELECT pwd_hash FROM gebruiker WHERE naam = :username LIMIT 1");
        $sth->execute(["username" => $input_username]);
        $data_row = $sth->fetch(PDO::FETCH_NUM);
        if ($data_row === false){
            $page_msg = "Gebruiker of wachtwoord onjuist!";
        }else{
            echo $data_row[0];
            $valid = password_verify($input_passsword, $data_row[0]);
            if ($valid){
                $_SESSION["user"] = $input_username;
                header("Location: index.php");
                exit;
            }else{
                $page_msg = "Gebuiker of wachtwoord onjuist!";
            }
        }
    }
}

$header_title = "Inloggen";
include("parts/header.php");
?>

<h2><?php if (isset($page_msg)) echo $page_msg ?></h2>
<form method="POST">
    <h2>Log in</h2>
    <input type="text" name="username">
    <input type="password" name="password">
    <input type="submit" name="login" value="Go">
</form>

<?php
include("parts/footer.php");