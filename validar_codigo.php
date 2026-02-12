<?php
header('Content-Type: application/json');

// ===== CONEXIÓN A BD =====
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafeteria_lensata";



$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["mensaje" => "Error de conexión a la base de datos."]);
    exit;
}

$codigo = $_POST['codigo'] ?? '';
$token = $_POST['token'] ?? '';

if (empty($codigo) || empty($token)) {
    echo json_encode(["mensaje" => "Faltan datos."]);
    exit;
}

// ===== VALIDAR TOKEN =====
$sql = "SELECT id, recupera_expira FROM usuarios WHERE recupera_token = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($idUsuario, $expira);
    $stmt->fetch();

    // Verificar expiración
    if (strtotime($expira) < time()) {
        echo json_encode(["mensaje" => "❌ El token ha expirado."]);
        exit;
    }

    // En este caso, el código es el mismo token
    if ($codigo === $token) {
        echo json_encode([
            "mensaje" => "✅ Código verificado correctamente.",
            "redirigir" => "nueva_contrasena.html?token=" . urlencode($token)
        ]);
    } else {
        echo json_encode(["mensaje" => "❌ Código incorrecto."]);
    }

} else {
    echo json_encode(["mensaje" => "❌ Token inválido."]);
}

$stmt->close();
$conn->close();
?>
