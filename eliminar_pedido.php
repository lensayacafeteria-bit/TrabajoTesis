<?php
$conexion = new mysqli("localhost", "root", "", "cafeteria_lensata");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$orden_id = intval($_POST['orden_id']);
$conexion->query("DELETE FROM carrito WHERE orden_id = $orden_id");

if ($conexion->affected_rows > 0) {
    echo "ok";
} else {
    echo "error";
}

$conexion->close();
?>
