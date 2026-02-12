<?php
$conexion = new mysqli("localhost", "root", "", "cafeteria_lensata");
if ($conexion->connect_error) {
  die("Error: " . $conexion->connect_error);
}

$id = $_GET['id'];
$sql = "DELETE FROM admin WHERE id='$id'";

if ($conexion->query($sql) === TRUE) {
  echo "Administrador eliminado correctamente.";
} else {
  echo "Error al eliminar: " . $conexion->error;
}

$conexion->close();
?>
