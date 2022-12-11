<?php
include "Database.php";
session_start();
$pl = $_POST['pl'];
$ids = $_POST['ids'];
Database::getConnection()->query("INSERT INTO playlistdatabase (idpl, ids) VALUES ('$pl', '$ids')");
Database::getConnection()->close();
header('Location: playlist_view.php?pl=' . $pl);

