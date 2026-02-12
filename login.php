<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafeteria_lensata";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Error de conexión: " . $conn->connect_error);

$mensaje_error = ""; // Variable para mostrar mensajes en el HTML

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $conn->real_escape_string($_POST['correo']);
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT * FROM usuarios WHERE correo='$correo' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        if (password_verify($contrasena, $usuario['contrasena'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            header("Location: dashboard.php");
            exit();
        } else {
            $mensaje_error = "❌ Contraseña incorrecta. Intenta nuevamente.";
        }
    } else {
        $mensaje_error = "❌ Usuario no encontrado. Verifica tus datos.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicia Sesión - Cafetería Lensaya</title>
  <link rel="icon" type="image/png" href="logo_cafeteria.jpeg">
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

    /* --- Mensaje de error --- */
    .mensaje-error {
      background: rgba(255, 0, 0, 0.1);
      border: 2px solid #d32f2f;
      color: #b71c1c;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 15px;
      font-weight: bold;
      font-size: 0.95rem;
      box-shadow: 0 0 5px rgba(211, 47, 47, 0.4);
      animation: aparecer 0.5s ease;
    }

    @keyframes aparecer {
      from {opacity: 0; transform: scale(0.95);}
      to {opacity: 1; transform: scale(1);}
    }

    .modal {
      position: fixed;
      z-index: 1000;
      left: 0; top: 0;
      width: 100%; height: 100%;
      overflow: auto;
      background: rgba(0,0,0,0.4);
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

    @media (min-width: 601px) and (max-width: 1024px) {
      .contenedor {
          width: 70vw;
          padding: 24px;
          border-radius: 12px;
      }
      .logo img {
          width: 120px;
          height: 120px;
      }
      .contenedor h2 {
          font-size: 1.5rem;
      }
    }

    @media (min-width: 1025px) {
      .contenedor {
          width: 350px;
      }
    }
  </style>
</head>
<body>
  <div class="contenedor">
    <div class="logo">
      <img src="logo_cafeteria.jpeg" alt="Logo Cafetería">
    </div>
    <h2>Inicia Sesión</h2>

    <?php if (!empty($mensaje_error)) : ?>
      <div class="mensaje-error">
        <?= $mensaje_error ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="input-box">
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required>
      </div>

      <div class="input-box">
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>
      </div>

      <button type="submit" class="btn">Entrar</button>
    </form>

    <p><a href="Registrarse.html">¿No tienes cuenta? Regístrate aquí</a></p>
  </div>
</body>
</html>
