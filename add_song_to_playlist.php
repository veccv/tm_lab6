<!DOCTYPE html>
<html>
<body>
<form action="add_song.php" method="post" enctype="multipart/form-data">
    <?php
    $playlist_id = $_GET['pl'];
    echo "<input type='hidden' name='pl' value='$playlist_id' />"
    ?>
    <label for="ids">Wybierz tytuł utworu: </label>
    <select id="ids" name="ids">
        <?php
        include "Database.php";
        $songs = mysqli_fetch_all(Database::getConnection()->query("SELECT * FROM song"));
        foreach ($songs as $song) {
            echo '<option value="' . $song[0] . '">' . $song[2] . ' - ' . $song[1] . '</option>';
        }

        ?>
    </select><br><br>
    <input type="submit" value="Dodaj piosenkę do tej playlisty" name="submit">
</form>
<br>
<br>
<br>
<br>
</body>
</html>