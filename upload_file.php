<!DOCTYPE html>
<html>
<body>
<form action="upload.php" method="post" enctype="multipart/form-data">
    Select file to upload: <br><br>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <br><br>
    <label for="title">Tytuł filmu: </label><input type="text" name="title" id="title">
    <br>
    <label for="director">Reżyser: </label><input type="text" name="director" id="director">
    <br><br>
    <label for="subtitles">Napisy:</label><br>
    <textarea rows="10" cols="100" id="subtitles" name="subtitles" placeholder="Wpisz napisy tutaj..."></textarea>
    <br>
    <label for="filmtype">Wybierz gatunek filmu: </label>
    <select id="filmtype" name="filmtype">
        <?php
        include 'Database.php';
        $rekord = mysqli_fetch_all(Database::getConnection()->query("SELECT * FROM filmtype"));

        foreach ($rekord as $value) {
            echo "<option value=" . $value[0] . ">" . $value[1] . "</option>";
        }
        ?>
    </select><br><br>
    <input type="submit" value="Upload" name="submit">
</form>
<br>
<p>Niepoprawny format, nie zostanie dodany do katalogu!</p>
<br>
<br>
<br>
<a href="index4.php">Powrót do katalogu użytkownika</a>
</body>
</html>