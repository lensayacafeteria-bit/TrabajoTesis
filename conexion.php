<?php
// --- CONEXIÓN LOCAL (CAFETERÍA LENSAYA) ---
$host_len = "localhost";
$user_len = "root";
$pass_len = "";
$db_len   = "cafeteria_lensata";

$conn = new mysqli($host_len, $user_len, $pass_len, $db_len);

if ($conn->connect_error) {
    die("Error de conexión a LENSAYA: " . $conn->connect_error);
}

// --- CONEXIÓN EXTERNA (INVENTARIO SAGI) ---
// Usamos PDO para ser compatibles con SAGI
$host_sagi = "localhost";
$db_sagi   = "sagi";
$user_sagi = "root";
$pass_sagi = "";

try {
    $pdo_sagi = new PDO("mysql:host=$host_sagi;dbname=$db_sagi;charset=utf8mb4", $user_sagi, $pass_sagi);
    $pdo_sagi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si falla SAGI, LENSAYA sigue funcionando pero avisamos del error
    error_log("No se pudo conectar al Inventario SAGI: " . $e->getMessage());
}
?>
