<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<HEAD>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</HEAD>
<BODY>
<?php
include 'Database.php';

$user = htmlentities($_POST['user'], ENT_QUOTES, "UTF-8");
$pass = htmlentities($_POST['pass'], ENT_QUOTES, "UTF-8");

if (!Database::getConnection()) {
    echo "Błąd: " . mysqli_connect_errno() . " " . mysqli_connect_error();
}


session_start();
$last_unsuccessful_login = $_SESSION['last_unsuccessful_login'];
$time_now = time();

//if (($last_unsuccessful_login + 60) < $time_now) {
    Database::getConnection()->query("SET NAMES 'utf8'");
    $rekord = mysqli_fetch_array(Database::getConnection()->query("SELECT * FROM user WHERE login='$user'"));

    if (!$rekord) //Jeśli brak, to nie ma użytkownika o podanym loginie
    {
        $_SESSION['last_unsuccessful_login'] = time();
        Database::getConnection()->close();
        header('Location: index3.php');
        exit();
    } else { // jeśli $rekord istnieje
        if ($rekord['password'] == $pass) // czy hasło zgadza się z BD
        {
            echo "Logowanie Ok. User: {$rekord['username']}. Hasło: {$rekord['password']}";
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['user'] = $user;

            header('Location: index4.php');
        } else {
            $_SESSION['last_unsuccessful_login'] = time();
            Database::getConnection()->close();
            header('Location: index3.php');
            exit();
        }
    }
//} else {
//    echo "Musisz poczekać minutę aby spróbować zalogować się ponownie!";
//}
?>
</BODY>
</HTML>