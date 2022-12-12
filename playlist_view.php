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
echo "<p>Filmy z playlisty:</p>";
$playlist_id = $_GET['pl'];
$films = mysqli_fetch_all(Database::getConnection()->query("SELECT * FROM playlistdatabase WHERE idpl='$playlist_id'"));

echo '<table style="border: 1px solid #000000; border-collapse: collapse; width: 100%;">';
echo '<thead>';
echo '<tr>';
echo '<th style="border: 1px solid #cccccc; padding: 8px;">Odtwórz</th>';
echo '<th style="border: 1px solid #cccccc; padding: 8px;">Tytuł</th>';
echo '<th style="border: 1px solid #cccccc; padding: 8px;">Reżyser</th>';
echo '<th style="border: 1px solid #cccccc; padding: 8px;">Data dodania</th>';
echo '<th style="border: 1px solid #cccccc; padding: 8px;">Użytkownik</th>';
echo '<th style="border: 1px solid #cccccc; padding: 8px;">Napisy</th>';
echo '<th style="border: 1px solid #cccccc; padding: 8px;">Gatunek filmowy</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
foreach ($films as $film) {
    $film_id = $film[2];
    $film_info = mysqli_fetch_array(Database::getConnection()->query("SELECT * FROM film WHERE idf='$film_id'"));
    echo '<tr>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px; width: 20%">';
    echo '<video src="films/' . $film_info[5] . '" autostart="0" controls width="500" height="200"></video>';
    echo '</td>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px;">' . $film_info[1] . '</td>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px;">' . $film_info[2] . '</td>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px;">' . $film_info[3] . '</td>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px;">' . mysqli_fetch_array(Database::getConnection()->query("SELECT * FROM user WHERE idu='$film_info[4]'"))[1] . '</td>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px;">';
    echo '<details>';
    echo '<summary>Kliknij tutaj, aby rozwinąć napisy</summary>';
    echo '<br>';

    $lines = explode("\n", $film_info[6]);

    foreach ($lines as $line) {
        echo "<p>$line</p>";
    }

    echo '</details>';

    echo '</td>';
    echo '<td style="border: 1px solid #cccccc; padding: 8px;">' . mysqli_fetch_array(Database::getConnection()->query("SELECT * FROM filmtype WHERE idft='$film_info[7]'"))[1] . '</td>';
    echo '</tr>';

}

$idu = mysqli_fetch_array(Database::getConnection()->query("SELECT * FROM user WHERE login='$user'"))[0];
if (mysqli_fetch_array(Database::getConnection()->query("SELECT * FROM playlistname WHERE idu='$idu' AND idpl='$playlist_id'"))[0]) {
    echo '<tr>' . '<td colspan="7" style="border: 1px solid #cccccc; padding: 8px;"><a href="add_video_to_playlist.php?pl=' . $playlist_id . '"> Dodaj film</a></td>' . '</tr>';
} else {
    echo '<tr>' . '<td colspan="7" style="border: 1px solid #cccccc; padding: 8px;"> To nie twoja playlista, nie możesz dodać filmu. </td>' . '</tr>';
}

echo '</tbody>';
echo '</table>';
