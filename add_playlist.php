<?php
include 'Database.php';
session_start();
$title = $_POST['title'];
$public = $_POST['public'];
$username = $_SESSION['user'];
$idu = mysqli_fetch_array(Database::getConnection()->query("SELECT * FROM user WHERE login='$username'"))[0];

Database::getConnection()->query("INSERT INTO playlistname (idu, name, public) VALUES ('$idu', '$title', '$public')");
Database::getConnection()->close();

header('Location: index4.php');