<?php
include 'Database.php';
session_start();

$target_dir = "films";
$target_file = $target_dir . "/" . basename($_FILES["fileToUpload"]["name"]);
$file_name = basename($_FILES["fileToUpload"]["name"]);

$title = $_POST['title'];
$director = $_POST['director'];
$subtitles = $_POST['subtitles'];
$filmtype = $_POST['filmtype'];

$login = $_SESSION['user'];
$idu = mysqli_fetch_array(Database::getConnection()->query("SELECT * FROM user WHERE login='$login'"))[0];

if (preg_match('/.mp4$/', $target_file)) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " uploaded.";
    } else {
        echo "Error uploading file.";
    }

    Database::getConnection()->query("INSERT INTO film (title, director, idu, filename, subtitles, idft) VALUES ('$title', '$director', '$idu', '$file_name', '$subtitles', '$filmtype')");
    Database::getConnection()->close();


    header('Location: index4.php');

} else {
    echo "Error uploading file.";
    header('Location: upload_file.php');
}


