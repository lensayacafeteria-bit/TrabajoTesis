<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "cafeteria_lensata");
if ($conexion->connect_error) {
  die("Error de conexión: " . $conexion->connect_error);
}

// Verificar si se pasó el ID
if (!isset($_GET['id'])) {
  die("ID no proporcionado.");
}

$id = $_GET['id'];

// Si se envió el formulario (actualización)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST['nombre'];
  $correo = $_POST['correo'];
  $contrasena = $_POST['contrasena'];

  // Si se ingresó una nueva contraseña, se encripta
  if (!empty($contrasena)) {
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
    $sql = "UPDATE admin SET nombre='$nombre', correo='$correo', contrasena='$contrasena_hash' WHERE id=$id";
  } else {
    // No se cambia la contraseña
    $sql = "UPDATE admin SET nombre='$nombre', correo='$correo' WHERE id=$id";
  }

  if ($conexion->query($sql) === TRUE) {
    echo "<script>alert('✅ Datos actualizados correctamente.'); window.location.href='gestionar_admin.html';</script>";
  } else {
    echo "Error al actualizar: " . $conexion->error;
  }
}

// Obtener los datos actuales del administrador
$sql = "SELECT * FROM admin WHERE id=$id";
$resultado = $conexion->query($sql);

if ($resultado->num_rows == 0) {
  die("Administrador no encontrado.");
}

$admin = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Administrador | Cafetería LenSaYa</title>
  <link rel="icon" type="image/png" href="logo_cafeteria.jpeg">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #1a1a1a, #333);
      color: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }

    h2 {
      color: #ffcc66;
      text-shadow: 0 0 10px #ffcc66;
    }

    form {
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(10px);
      padding: 25px;
      border-radius: 10px;
      width: 350px;
      box-shadow: 0 0 15px rgba(255, 255, 255, 0.2);
    }

    label {
      display: block;
      margin-top: 12px;
      color: #ffcc66;
      font-weight: bold;
    }

    input {
      width: 100%;
      padding: 8px;
      border-radius: 6px;
      border: none;
      outline: none;
      margin-top: 5px;
      background: rgba(255, 255, 255, 0.2);
      color: white;
    }

    input::placeholder {
      color: #ddd;
    }

    button {
      margin-top: 20px;
      width: 100%;
      padding: 10px;
      background-color: #ffcc66;
      color: #000;
      font-weight: bold;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover {
      background-color: #ffb84d;
    }

    a {
      color: #ffcc66;
      text-decoration: none;
      display: inline-block;
      margin-top: 15px;
    }

    a:hover {
      text-decoration: underline;
    }
    .agregar {
      background-color: #ffcc66;
      color: #000;
      margin-bottom: 20px;
      display: inline-block;
      padding: 8px 14px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
    }

    .agregar:hover {
      background-color: #ffb84d;
      box-shadow: 0 0 8px #ffcc66;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <h2>Editar Administrador</h2>

  <form method="POST">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($admin['nombre']); ?>" required>

    <label for="correo">Correo:</label>
    <input type="email" name="correo" id="correo" value="<?php echo htmlspecialchars($admin['correo']); ?>" required>

    <label for="contrasena">Nueva Contraseña (opcional):</label>
    <input type="password" name="contrasena" id="contrasena" placeholder="Dejar en blanco para no cambiarla">

    <button type="submit">💾 Guardar Cambios</button>
  </form>

  <a href="gestionar_admin.php" class="agregar">⬅ Regresar al Panel de administración</a>
</body>
</html>

<?php $conexion->close(); ?>
