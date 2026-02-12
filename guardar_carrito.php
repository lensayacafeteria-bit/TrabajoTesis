<?php
header('Content-Type: application/json');

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "cafeteria_lensata");
if ($conexion->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conexion->connect_error]));
}

$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !isset($data['productos'])) {
    http_response_code(400);
    echo json_encode(["error" => "Datos inválidos"]);
    exit;
}

// Generar un nuevo orden_id (mayor que el actual)
$result = $conexion->query("SELECT IFNULL(MAX(orden_id), 0) + 1 AS nuevo_id FROM carrito");
$row = $result->fetch_assoc();
$orden_id = $row['nuevo_id'];

// Insertar cada producto con el mismo orden_id
foreach ($data['productos'] as $p) {
    $producto = $conexion->real_escape_string($p['nombre']);
    $precio = (float)$p['precio'];
    $cantidad = (int)$p['cantidad'];
    $subtotal = $precio * $cantidad;

    $conexion->query("INSERT INTO carrito (orden_id, producto, precio, cantidad, subtotal)
                      VALUES ($orden_id, '$producto', $precio, $cantidad, $subtotal)");
}

echo json_encode(["success" => true, "orden_id" => $orden_id]);
$conexion->close();
?>
