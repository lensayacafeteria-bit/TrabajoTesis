<?php
$conexion = new mysqli("localhost", "root", "", "cafeteria_lensata");

if ($conexion->connect_error) {
  die(json_encode(["success" => false, "error" => "Error de conexión"]));
}

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? null;

if ($id) {
  $campos = ["nombre", "apellido_paterno", "apellido_materno", "telefono", "correo"];
  $sets = [];

  foreach ($campos as $campo) {
    if (isset($data[$campo])) {
      $valor = $conexion->real_escape_string($data[$campo]);
      $sets[] = "$campo='$valor'";
    }
  }

  if (!empty($sets)) {
    $sql = "UPDATE usuarios SET " . implode(",", $sets) . " WHERE id='$id'";
    $resultado = $conexion->query($sql);
    echo json_encode(["success" => $resultado]);
  } else {
    echo json_encode(["success" => false, "error" => "Sin datos para actualizar"]);
  }
} else {
  echo json_encode(["success" => false, "error" => "ID no proporcionado"]);
}

$conexion->close();
?>
