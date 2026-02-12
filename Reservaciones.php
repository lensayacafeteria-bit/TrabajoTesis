<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafeteria_lensata";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { 
    die("<div class='error-box'>❌ Error en la conexión: " . $conn->connect_error . "</div>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre   = $conn->real_escape_string($_POST['nombre']);
    $telefono = $conn->real_escape_string($_POST['telefono']);
    $correo   = $conn->real_escape_string($_POST['correo']);
    $fecha    = $conn->real_escape_string($_POST['fecha']);
    $hora     = $conn->real_escape_string($_POST['hora']);
    $personas = $conn->real_escape_string($_POST['personas']);
    $mensaje  = $conn->real_escape_string($_POST['mensaje']);

    $sql = "INSERT INTO reservaciones (nombre, telefono, correo, fecha, hora, personas, mensaje) 
            VALUES ('$nombre', '$telefono', '$correo', '$fecha', '$hora', '$personas', '$mensaje')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='success-box'>
                <h2>✅ Reservación realizada exitosamente</h2>
                <p>Gracias por reservar con nosotros. Te esperamos en la fecha indicada.</p>
                <a href='Menu_Principal.html' class='btn'>Volver al Menú Principal</a>
              </div>";
    } else {
        echo "<div class='error-box'>
                <h2>❌ Error al registrar la reservación</h2>
                <p>" . $conn->error . "</p>
                <a href='Reservaciones.html' class='btn'>Intentar de nuevo</a>
              </div>";
    }
}
$conn->close();
?>

<style>

body {
  font-family: 'Segoe UI', Arial, sans-serif;
  background: url('fondo2.png') no-repeat center center fixed;
  background-size: cover;
  margin: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  color: white;
}

.success-box, .error-box {
  background: rgba(0, 0, 0, 0.8);
  border-radius: 20px;
  padding: 40px 60px;
  text-align: center;
  box-shadow: 0 0 20px #ffffff;
  max-width: 500px;
  animation: fadeIn 1s ease-in-out;
}

.success-box h2 {
  color: #00ff88;
  font-size: 1.8em;
  margin-bottom: 10px;
}

.error-box h2 {
  color: #ff5555;
  font-size: 1.8em;
  margin-bottom: 10px;
}

.success-box p, .error-box p {
  color: #ccc;
  font-size: 1em;
  margin-bottom: 20px;
}

.btn {
  display: inline-block;
  background: linear-gradient(45deg, #00c3ff, #0078ff);
  color: white;
  padding: 12px 25px;
  border-radius: 25px;
  text-decoration: none;
  font-weight: bold;
  transition: all 0.3s ease;
}

.btn:hover {
  background: linear-gradient(45deg, #00ffcc, #0099ff);
  box-shadow: 0 0 15px #00ffcc;
  transform: scale(1.05);
}

@keyframes fadeIn {
  from { opacity: 0; transform: scale(0.8); }
  to { opacity: 1; transform: scale(1); }
}
</style>