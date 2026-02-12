<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafeteria_lensata";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Error de conexión: " . $conn->connect_error);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($conn->real_escape_string($_POST['nombre']));
    $correo = trim($conn->real_escape_string($_POST['correo']));
    $contrasena = $_POST['contrasena'];
    $confirmar = $_POST['confirmar'];

    // ===== CSS REUTILIZABLE =====
    $estilos = "
    <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Georgia', serif;
      background: url('fondo.png') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    .contenedor {
      background: url('fondo2.png') no-repeat center center;
      background-size: cover;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0,0,0,0.3);
      text-align: center;
      max-width: 500px;
      width: 100%;
      backdrop-filter: blur(10px);
      border: 2px solid rgba(255,255,255,0.1);
    }

    h2 {
      color: #3e2723;
      margin-bottom: 20px;
      font-size: 2.2rem;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }

    p {
      color: #3e2723;
      font-size: 1.3rem;
      margin-bottom: 30px;
      line-height: 1.6;
      font-weight: 500;
    }

    .btn {
      display: inline-block;
      background: #6b3e26;
      color: #fff;
      text-decoration: none;
      padding: 15px 40px;
      font-size: 1.2rem;
      border-radius: 50px;
      border: none;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(107, 62, 38, 0.4);
      font-weight: bold;
    }

    .btn:hover {
      background: #8d5a44;
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(107, 62, 38, 0.6);
    }
    </style>
    ";

    // ===== VALIDACIONES =====

    if ($contrasena !== $confirmar) {
        echo "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Error</title>
        $estilos
        </head>
        <body>
          <div class='contenedor'>
            <h2>⚠️ Error</h2>
            <p>Las contraseñas no coinciden.<br>Por favor, verifica e inténtalo nuevamente.</p>
            <button class='btn' onclick='window.history.back()'>Volver</button>
          </div>
        </body>
        </html>";
        exit;
    }

    $check = $conn->query("SELECT * FROM admin WHERE correo='$correo'");
    if ($check->num_rows > 0) {
        echo "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Correo Registrado</title>
        $estilos
        </head>
        <body>
          <div class='contenedor'>
            <h2>⚠️ Correo ya registrado</h2>
            <p>Este correo electrónico ya está en uso.<br>Intenta con otro o inicia sesión.</p>
            <button class='btn' onclick='window.history.back()'>Volver</button>
          </div>
        </body>
        </html>";
        exit;
    }

    $hash = password_hash($contrasena, PASSWORD_DEFAULT);
    $sql = "INSERT INTO admin (nombre, correo, contrasena, tipo) VALUES ('$nombre', '$correo', '$hash', 'admin')";

    if ($conn->query($sql) === TRUE) {
        echo "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Registro Exitoso</title>
        $estilos
        </head>
        <body>
          <div class='contenedor'>
            <h2>✅ Registro exitoso</h2>
            <p>Tu cuenta ha sido creada correctamente.<br>Ahora puedes iniciar sesión.</p>
            <button class='btn' onclick=\"window.location.href='adminlogin.html'\">Iniciar Sesión</button>
          </div>
        </body>
        </html>";
    } else {
        echo "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Error del Sistema</title>
        $estilos
        </head>
        <body>
          <div class='contenedor'>
            <h2>❌ Error del sistema</h2>
            <p>Ocurrió un problema al registrar el administrador.<br>Por favor, intenta nuevamente más tarde.</p>
            <button class='btn' onclick='window.history.back()'>Volver</button>
          </div>
        </body>
        </html>";
    }
}

$conn->close();
?>
