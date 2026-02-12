<?php
header('Content-Type: application/json');

// Conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafeteria_lensata";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["mensaje" => "Error de conexión a la base de datos."]);
    exit;
}

$token = $_POST['token'] ?? '';
$nueva = $_POST['nueva'] ?? '';

if (empty($token) || empty($nueva)) {
    echo json_encode(["mensaje" => "Datos incompletos."]);
    exit;
}

// Encriptar contraseña
$hash = password_hash($nueva, PASSWORD_DEFAULT);

// Verificar token válido
$sql = "SELECT id FROM usuarios WHERE recupera_token = ? AND recupera_expira > NOW()";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($idUsuario);
    $stmt->fetch();

    // Actualizar contraseña y limpiar token
    $sql2 = "UPDATE usuarios SET contrasena = ?, recupera_token = NULL, recupera_expira = NULL WHERE id = ?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("si", $hash, $idUsuario);
    $stmt2->execute();

    echo json_encode(["mensaje" => "✅ Contraseña actualizada correctamente."]);
    $stmt2->close();
} else {
    echo json_encode(["mensaje" => "❌ Token inválido o expirado."]);
}

$stmt->close();
$conn->close();
?>
