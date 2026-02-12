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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $apellido_paterno = $conn->real_escape_string($_POST['apellido_paterno']);
    $apellido_materno = $conn->real_escape_string($_POST['apellido_materno']);
    $telefono = $conn->real_escape_string($_POST['telefono']);
    $correo = $conn->real_escape_string($_POST['correo']);
    $contrasena = $_POST['contrasena'];
    $confirmar = $_POST['confirmar'];

    if ($contrasena !== $confirmar) {
        echo "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Error de Registro</title>
            <style>
                body {
                    margin: 0;
                    padding: 0;
                    color:black;
                    background: url('fondo.png');
                    font-family: Arial, sans-serif;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                }
                .notificacion {
                    background: linear-gradient(180deg, #dc3545 0%, #c82333 100%);
                    color: white;
                    padding: 30px 40px;
                    border-radius: 15px;
                    box-shadow: 0 10px 30px rgba(0,0,0,0.4);
                    display: flex;
                    align-items: center;
                    max-width: 450px;
                    text-align: center;
                    border: 3px solid rgba(255,255,255,0.2);
                }
                .notificacion i {
                    margin-right: 20px;
                    font-size: 42px;
                    flex-shrink: 0;
                }
                .notificacion-contenido h3 {
                    margin: 0 0 10px 0;
                    font-size: 24px;
                    font-weight: bold;
                }
                .notificacion-contenido p {
                    margin: 0;
                    font-size: 16px;
                    opacity: 0.9;
                    line-height: 1.5;
                }
            </style>
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css'>
        </head>
        <body>
            <div class='notificacion'>
                <i class='fas fa-exclamation-triangle'></i>
                <div class='notificacion-contenido'>
                    <h3>Error de Registro</h3>
                    <p>Las contraseñas no coinciden</p>
                </div>
            </div>
            <script>
                setTimeout(() => {
                    window.history.back();
                }, 3000);
            </script>
        </body>
        </html>";
        exit;
    }

    $check = $conn->query("SELECT * FROM usuarios WHERE correo='$correo'");
    if ($check->num_rows > 0) {
        echo "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Error de Registro</title>
            <style>
                body {
                    margin: 0;
                    padding: 0;
                    colo:black;
                    background: url('fondo.png');
                    font-family: Arial, sans-serif;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                }
                .notificacion {
                    background: linear-gradient(180deg, #dc3545 0%, #c82333 100%);
                    color: white;
                    padding: 30px 40px;
                    border-radius: 15px;
                    box-shadow: 0 10px 30px rgba(0,0,0,0.4);
                    display: flex;
                    align-items: center;
                    max-width: 450px;
                    text-align: center;
                    border: 3px solid rgba(255,255,255,0.2);
                }
                .notificacion i {
                    margin-right: 20px;
                    font-size: 42px;
                    flex-shrink: 0;
                }
                .notificacion-contenido h3 {
                    margin: 0 0 10px 0;
                    font-size: 24px;
                    font-weight: bold;
                }
                .notificacion-contenido p {
                    margin: 0;
                    font-size: 16px;
                    opacity: 0.9;
                    line-height: 1.5;
                }
            </style>
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css'>
        </head>
        <body>
            <div class='notificacion'>
                <i class='fas fa-exclamation-circle'></i>
                <div class='notificacion-contenido'>
                    <h3>Correo Ya Registrado</h3>
                    <p>Este correo electrónico ya está en uso</p>
                </div>
            </div>
            <script>
                setTimeout(() => {
                    window.history.back();
                }, 3000);
            </script>
        </body>
        </html>";
        exit;
    }

    $hash = password_hash($contrasena, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, apellido_paterno, apellido_materno, telefono, correo, contrasena)
            VALUES ('$nombre','$apellido_paterno','$apellido_materno','$telefono','$correo','$hash')";

    if ($conn->query($sql) === TRUE) {
        echo "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Registro Exitoso</title>
            <style>
                body {
                    margin: 0;
                    color:black;
                    padding: 0;
                    background: url('fondo.png');
                    font-family: Arial, sans-serif;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                }
                .notificacion {
                    background: url('fondo2.png');
                    color: white;
                    padding: 30px 40px;
                    border-radius: 15px;
                    box-shadow: 0 10px 30px rgba(0,0,0,0.4);
                    display: flex;
                    align-items: center;
                    max-width: 450px;
                    text-align: center;
                    border: 3px solid rgba(255,255,255,0.2);
                }
                .notificacion i {
                    margin-right: 20px;
                    font-size: 42px;
                    flex-shrink: 0;
                }
                .notificacion-contenido h3 {
                    margin: 0 0 10px 0;
                    font-size: 24px;
                    font-weight: bold;
                }
                .notificacion-contenido p {
                    margin: 0;
                    font-size: 16px;
                    opacity: 0.9;
                    line-height: 1.5;
                }
            </style>
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css'>
        </head>
        <body>
            <div class='notificacion'>
                <i class='fas fa-check-circle'></i>
                <div class='notificacion-contenido'>
                    <h3>¡Registro Exitoso!</h3>
                    <p>Ahora puedes iniciar sesión en tu cuenta</p>
                </div>
            </div>
            <script>
                setTimeout(() => {
                    window.location.href = 'index.html';
                }, 3000);
            </script>
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
            <style>
                body {
                    margin: 0;
                    color:black;
                    padding: 0;
                    background: url('fondo.png');
                    font-family: Arial, sans-serif;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                }
                .notificacion {
                    background: url('fondo: 2png');s
                    color: white;
                    padding: 30px 40px;
                    border-radius: 15px;
                    box-shadow: 0 10px 30px rgba(0,0,0,0.4);
                    display: flex;
                    align-items: center;
                    max-width: 450px;
                    text-align: center;
                    border: 3px solid rgba(255,255,255,0.2);
                }
                .notificacion i {
                    margin-right: 20px;
                    font-size: 42px;
                    flex-shrink: 0;
                }
                .notificacion-contenido h3 {
                    margin: 0 0 10px 0;
                    font-size: 24px;
                    font-weight: bold;
                }
                .notificacion-contenido p {
                    margin: 0;
                    font-size: 16px;
                    opacity: 0.9;
                    line-height: 1.5;
                }
            </style>
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css'>
        </head>
        <body>
            <div class='notificacion'>
                <i class='fas fa-exclamation-triangle'></i>
                <div class='notificacion-contenido'>
                    <h3>Error del Sistema</h3>
                    <p>Ocurrió un error inesperado. Intenta nuevamente.</p>
                </div>
            </div>
            <script>
                setTimeout(() => {
                    window.history.back();
                }, 3000);
            </script>
        </body>
        </html>";
    }
}
$conn->close();
?>