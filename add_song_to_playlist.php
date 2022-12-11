<!DOCTYPE html>
<html>
<body>
<form action="add_song.php" method="post" enctype="multipart/form-data">
    <?php
    $playlist_id = $_GET['pl'];
    echo "<input type='hidden' name='pl' value='$playlist_id' />"
    ?>
    <label for="ids">Wybierz tytuł filmu: </label>
    <select id="ids" name="ids">
        <?php
        include "Database.php";
        $films = mysqli_fetch_all(Database::getConnection()->query("SELECT * FROM film"));
        foreach ($films as $film) {
            echo '<option value="' . $film[0] . '">' . $film[2] . ' - ' . $film[1] . '</option>';
        }

        ?>
    </select><br><br>
    <input type="submit" value="Dodaj film do tej playlisty" name="submit">
</form>
<br>
<br>
<br>
<br>
</body>
</html>