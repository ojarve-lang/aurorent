<?php
$host = "localhost";
$user = "autorent_user";
$pass = "MinuParool123!";
$dbname = "autorent";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Andmebaasi ühendus ebaõnnestus: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
