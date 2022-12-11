<!DOCTYPE html>
<html>
<body>
<form action="add_playlist.php" method="post" enctype="multipart/form-data">
    <label for="title">Tytuł playlisty: </label><input type="text" name="title" id="title">
    <br>
    <br>
    <label for="public">Dostępność playlisty: </label>
    <select id="public" name="public">
        <option value="1">Publiczna</option>
        <option value="0">Prywatna</option>
    </select><br><br>
    <input type="submit" value="Stwórz playlistę" name="submit">
</form>
<br>
<br>
<br>
<br>
<a href="index4.php">Powrót do katalogu użytkownika</a>
</body>
</html>