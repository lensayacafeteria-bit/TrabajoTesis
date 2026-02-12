<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafeteria_lensata";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Error de conexión: " . $conn->connect_error);

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $conn->real_escape_string($_POST['correo']);
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT * FROM admin WHERE correo='$correo' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        if (password_verify($contrasena, $usuario['contrasena'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['tipo'] = $usuario['tipo'];
            header("Location: admin.html");
            exit();
        } else {
            $mensaje = "❌ Contraseña incorrecta.";
            $tipo_mensaje = "error";
        }
    } else {
        $mensaje = "⚠️ Usuario no encontrado.";
        $tipo_mensaje = "error";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión | Cafetería</title>
  <link rel="icon" type="image/png" href="logo_cafeteria.jpeg" />
  <style>
    /* === Estilos principales adaptados === */
    body {
      font-family: 'Georgia', serif;
      margin: 0;
      background: url(fondo.png);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 120vh;
    }

    .contenedor {
      background: url(fondo2.png);
      padding: 30px;
      border-radius: 15px;
      width: 350px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
      text-align: center;
      position: relative;
    }

    .contenedor h2 {
      color: #3e2723;
      margin-bottom: 20px;
      font-size: 1.8rem;
    }

    .input-box {
      margin-bottom: 18px;
      text-align: left;
      position: relative;
    }

    .input-box label {
      display: block;
      font-weight: bold;
      color: #3e2723;
      margin-bottom: 5px;
    }

    .input-box input {
      width: 90%;
      padding: 10px 40px 10px 10px;
      border: 3px solid #0f0f0f;
      border-radius: 8px;
      font-size: 0.9rem;
      outline: none;
      background-color: rgba(255,255,255,0.9);
    }

    .btn {
      width: 100%;
      background: #6b3e26;
      color: #fff;
      border: none;
      padding: 12px;
      font-size: 1rem;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 10px;
      transition: background 0.3s;
    }

    .btn:hover {
      background: #8d5a44;
    }

    .logo {
      margin-top: 20px;
    }

    .logo img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
    }

    a {
      color: #111111;
      text-decoration: none; 
      font-weight: bold;
      font-family: 'Segoe UI', cursive, sans-serif;
      font-size: 1.1em;
    }

    .mensaje {
      margin-top: 15px;
      padding: 12px;
      border-radius: 8px;
      font-weight: bold;
      font-size: 1rem;
      width: 90%;
      margin-left: auto;
      margin-right: auto;
    }

    .mensaje.error {
      background-color: rgba(255, 0, 0, 0.15);
      color: #b71c1c;
      border: 1.5px solid #b71c1c;
    }

    .mensaje.exito {
      background-color: rgba(0, 128, 0, 0.15);
      color: #1b5e20;
      border: 1.5px solid #1b5e20;
    }

    @media (max-width: 600px) {
      .contenedor {
          width: 95vw;
          padding: 18px;
          border-radius: 10px;
      }
      .logo img {
          width: 90px;
          height: 90px;
      }
      .contenedor h2 {
          font-size: 1.2rem;
      }
      .btn {
          font-size: 0.95rem;
          padding: 10px;
      }
    }
  </style>
</head>
<body>
  <div class="contenedor">
    <div class="logo">
      <img src="logo_cafeteria.jpeg" alt="Logo Cafetería">
    </div>

    <h2>Inicio de Sesión</h2>

    <?php if (!empty($mensaje)): ?>
      <div class="mensaje <?= $tipo_mensaje; ?>"><?= $mensaje; ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="input-box">
        <label for="correo">Correo:</label>
        <input type="email" name="correo" id="correo" required>
      </div>

      <div class="input-box">
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena" required>
      </div>

      <button type="submit" class="btn">Iniciar Sesión</button>
    </form>
  </div>
</body>
</html>
