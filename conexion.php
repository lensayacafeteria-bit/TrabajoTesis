<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafeteria_lensata";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
