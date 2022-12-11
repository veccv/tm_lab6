<?php
include 'Database.php';
session_start();

$target_dir = "songs";
$target_file = $target_dir . "/" . basename($_FILES["fileToUpload"]["name"]);
$file_name = basename($_FILES["fileToUpload"]["name"]);

$title = $_POST['title'];
$musician = $_POST['musician'];
$lyrics = $_POST['lyrics'];
$musictype_id = $_POST['musictype'];

$login = $_SESSION['user'];
$idu = mysqli_fetch_array(Database::getConnection()->query("SELECT * FROM user WHERE login='$login'"))[0];

if (preg_match('/.mp3$/', $target_file)) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " uploaded.";
    } else {
        echo "Error uploading file.";
    }

    Database::getConnection()->query("INSERT INTO song (title, musician, idu, filename, lyrics, idmt) VALUES ('$title', '$musician', '$idu', '$file_name', '$lyrics', '$musictype_id')");
    Database::getConnection()->close();


    header('Location: index4.php');

} else {
    echo "Error uploading file.";
    header('Location: upload_file.php');
}


