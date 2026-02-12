<?php
$conexion = new mysqli("localhost", "root", "", "cafeteria_lensata");

if ($conexion->connect_error) {
  die(json_encode(["success" => false, "error" => "Error de conexión"]));
}

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? null;

if ($id) {
  $sql = "DELETE FROM usuarios WHERE id='$id'";
  $resultado = $conexion->query($sql);
  echo json_encode(["success" => $resultado]);
} else {
  echo json_encode(["success" => false, "error" => "ID no proporcionado"]);
}

$conexion->close();
?>
