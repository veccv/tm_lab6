<?php declare(strict_types=1);
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: index3.php');
    exit();
}

$user = $_SESSION['user'];

include 'Database.php';
if (!Database::getConnection()) {
    echo "Błąd: " . mysqli_connect_errno() . " " . mysqli_connect_error();
}
Database::getConnection()->query("SET NAMES 'utf8'");
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<BODY style="padding: 15px">
<a href="logout.php">Wyloguj się</a>
<br>
<a href="index.php">Powrót do menu głównego</a>
<br>
<br>
<br>
<br>
<?php
echo "Wyślij plik muzyczny ";
echo '<a href="upload_file.php"><i class="glyphicon glyphicon-cloud-upload fa-6x"></i> </a><br><br>';

echo "Stwórz playliste ";
echo '<a href="create_playlist.php"><i class="glyphicon glyphicon-plus glyphicon-lg"></i> </a><br><br>';

echo "<p>Wybierz utwór do odtworzenia:</p>";
$songs = mysqli_fetch_all(Database::getConnection()->query("SELECT * FROM song"));

echo '<table style="border: 1px solid #000000; border-collapse: collapse; width: 100%;">';
echo '<thead>';
echo '<tr>';
echo '<th style="border: 1px solid #cccccc; padding: 40px;">Odtwórz</th>';
echo '<th style="border: 1px solid #cccccc; padding: 8px;">Tytuł</th>';
echo '<th style="border: 1px solid #cccccc; padding: 8px;">Autor</th>';
echo '<th style="border: 1px solid #cccccc; padding: 8px;">Data dodania</th>';
echo '<th style="border: 1px solid #cccccc; padding: 8px;">Użytkownik</th>';
echo '<th style="border: 1px solid #cccccc; padding: 8px;">Tekst piosenki</th>';
echo '<th style="border: 1px solid #cccccc; padding: 8px;">Gatunek muzyczny</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
foreach ($songs as $song) {
    echo '<tr>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px;">';
    echo '<audio controls style="width: 100%">';
    echo '<source src="songs/' . $song[5] . '" type="audio/mpeg">';
    echo 'Twoja przeglądarka nie obsługuje odtwarzacza audio.';
    echo '</audio>';

    echo '</td>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px;">' . $song[1] . '</td>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px;">' . $song[2] . '</td>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px;">' . $song[3] . '</td>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px;">' . mysqli_fetch_array(Database::getConnection()->query("SELECT * FROM user WHERE idu='$song[4]'"))[1] . '</td>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px;">';
    echo '<details>';
    echo '<summary>Kliknij tutaj, aby rozwinąć tekst piosenki</summary>';
    echo '<br>';

    $lines = explode("\n", $song[6]);

    foreach ($lines as $line) {
        echo "<p>$line</p>";
    }

    echo '</details>';

    echo '</td>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px;">' . mysqli_fetch_array(Database::getConnection()->query("SELECT * FROM musictype WHERE idmt='$song[7]'"))[1] . '</td>';
    echo '</tr>';

}
echo '</tbody>';
echo '</table>';

echo '<br><br>';
echo 'Wybierz playlistę: <br>';
$uid = mysqli_fetch_array(Database::getConnection()->query("SELECT * FROM user WHERE login='$user'"))[0];
$playlists = mysqli_fetch_all(Database::getConnection()->query("SELECT * FROM playlistname WHERE public='1' OR idu='$uid'"));

echo '<table style="border: 1px solid #000000; border-collapse: collapse; width: 100%;">';
echo '<thead>';
echo '<tr>';
echo '<th style="border: 1px solid #cccccc; padding: 8px;">Nazwa playlisty</th>';
echo '<th style="border: 1px solid #cccccc; padding: 8px;">Utworzona przez</th>';
echo '<th style="border: 1px solid #cccccc; padding: 8px;">Data dodania</th>';
echo '<th style="border: 1px solid #cccccc; padding: 8px;">Typ playlisty</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
foreach ($playlists as $playlist) {
    echo '<tr>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px;"> <a href="playlist_view.php?pl='. $playlist[0] . '">' . $playlist[2] . '</td>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px;">' . mysqli_fetch_array(Database::getConnection()->query("SELECT * FROM user WHERE idu='$playlist[1]'"))[1] . '</td>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px;">' . $playlist[4] . '</td>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px;">';
    if ($playlist[3] == '1') {
        echo 'Publiczna';
    } else {
        echo 'Prywatna';
    }

    echo '</td>';
    echo '</tr>';

}
echo '</tbody>';
echo '</table>';


?>
</BODY>
</HTML>