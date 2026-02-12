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
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $apellido = $conn->real_escape_string($_POST['apellidos']);
    $calle = $conn->real_escape_string($_POST['calle']);
    $colonia = $conn->real_escape_string($_POST['colonia']);
    $num_ext_int = $conn->real_escape_string($_POST['num_ext_int']);
    $codigo_postal = $conn->real_escape_string($_POST['codigo_postal']);
    $referencias = $conn->real_escape_string($_POST['referencias']);

    $sql = "INSERT INTO pedidos (nombre, apellidos, calle, colonia, num_ext_int, codigo_postal, referencias) 
            VALUES ('$nombre', '$apellido', '$calle', '$colonia', '$num_ext_int', '$codigo_postal', '$referencias')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='success-box'>
                <h2>✅ Pedido realizado con éxito</h2>
                <a href='Menu_Principal.html' class='btn'>Volver al menú principal</a>
              </div>";
    } else {
        echo "<div class='error-box'>
                <h2>❌ Error al registrar el pedido</h2>
                <p>" . $conn->error . "</p>
                <a href='pedidos.html' class='btn'>Intentar de nuevo</a>
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
  box-shadow: 0 0 20px #fff;
  animation: aparecer 1s ease;
}

.success-box h2 {
  color: #00ff88;
  font-size: 1.8em;
}

.error-box h2 {
  color: #ff5555;
  font-size: 1.8em;
}

.btn {
  display: inline-block;
  margin-top: 20px;
  background: linear-gradient(45deg, #00c3ff, #0078ff);
  color: white;
  padding: 12px 25px;
  border-radius: 25px;
  text-decoration: none;
  font-weight: bold;
  transition: 0.3s;
}

.btn:hover {
  background: linear-gradient(45deg, #00ffcc, #0099ff);
  box-shadow: 0 0 10px #00ffcc;
}

@keyframes aparecer {
  from { opacity: 0; transform: scale(0.8); }
  to { opacity: 1; transform: scale(1); }
}
</style>