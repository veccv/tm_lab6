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
echo '<a href="index4.php">Powrót do menu użytkownika</a>';

echo '<br><br>';
echo "<p>Piosenki z playlisty:</p>";
$playlist_id = $_GET['pl'];
$songs = mysqli_fetch_all(Database::getConnection()->query("SELECT * FROM playlistdatabase WHERE idpl='$playlist_id'"));

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
    $song_id = $song[2];
    $song_info = mysqli_fetch_array(Database::getConnection()->query("SELECT * FROM song WHERE ids='$song_id'"));

    echo '<tr>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px;">';
    echo '<audio controls style="width: 100%">';
    echo '<source src="songs/' . $song_info[5] . '" type="audio/mpeg">';
    echo 'Twoja przeglądarka nie obsługuje odtwarzacza audio.';
    echo '</audio>';

    echo '</td>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px;">' . $song_info[1] . '</td>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px;">' . $song_info[2] . '</td>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px;">' . $song_info[3] . '</td>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px;">' . mysqli_fetch_array(Database::getConnection()->query("SELECT * FROM user WHERE idu='$song_info[4]'"))[1] . '</td>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px;">';
    echo '<details>';
    echo '<summary>Kliknij tutaj, aby rozwinąć tekst piosenki</summary>';
    echo '<br>';

    $lines = explode("\n", $song_info[6]);

    foreach ($lines as $line) {
        echo "<p>$line</p>";
    }

    echo '</details>';

    echo '</td>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px;">' . mysqli_fetch_array(Database::getConnection()->query("SELECT * FROM musictype WHERE idmt='$song_info[7]'"))[1] . '</td>';
    echo '</tr>';

}

$idu = mysqli_fetch_array(Database::getConnection()->query("SELECT * FROM user WHERE login='$user'"))[0];
if (mysqli_fetch_array(Database::getConnection()->query("SELECT * FROM playlistname WHERE idu='$idu' AND idpl='$playlist_id'"))[0]) {
    echo '<tr>' . '<td colspan="7" style="border: 1px solid #cccccc; padding: 8px;"><a href="add_song_to_playlist.php?pl=' . $playlist_id . '"> Dodaj piosenkę</a></td>' . '</tr>';
} else {
    echo '<tr>' . '<td colspan="7" style="border: 1px solid #cccccc; padding: 8px;"> To nie twoja playlista, nie możesz dodać piosenki. </td>' . '</tr>';
}

echo '</tbody>';
echo '</table>';
