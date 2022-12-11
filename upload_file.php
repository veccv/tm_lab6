<!DOCTYPE html>
<html>
<body>
<form action="upload.php" method="post" enctype="multipart/form-data">
    Select file to upload: <br><br>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <br><br>
    <label for="title">Tytuł utworu: </label><input type="text" name="title" id="title">
    <br>
    <label for="musician">Autor: </label><input type="text" name="musician" id="musician">
    <br><br>
    <label for="lyrics">Tekst piosenki:</label><br>
    <textarea rows="10" cols="100" id="lyrics" name="lyrics" placeholder="Wpisz tekst piosenki tutaj..."></textarea>
    <br>
    <label for="musictype">Wybierz gatunek utworu: </label>
    <select id="musictype" name="musictype">
        <?php
        include 'Database.php';
        $rekord = mysqli_fetch_all(Database::getConnection()->query("SELECT * FROM musictype"));

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