<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "cafeteria_lensata");
if ($conexion->connect_error) {
  die("Error de conexión: " . $conexion->connect_error);
}

// Eliminar administrador
if (isset($_GET['eliminar'])) {
  $id = $_GET['eliminar'];
  $conexion->query("DELETE FROM admin WHERE id=$id");
  header("Location: gestionar_admin.php");
  exit();
}

// Buscar administradores
$busqueda = "";
if (isset($_GET['buscar'])) {
  $busqueda = $_GET['buscar'];
  $sql = "SELECT * FROM admin WHERE nombre LIKE '%$busqueda%' OR correo LIKE '%$busqueda%'";
} else {
  $sql = "SELECT * FROM admin";
}

$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestionar Administradores | Cafetería LenSaYa</title>
  <link rel="icon" type="image/png" href="logo_cafeteria.jpeg">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #3b2e2a, #1e1715);
      color: #f7f3ef;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    header {
      text-align: center;
      padding: 25px;
    }

    header h1 {
      color: #ffdd99;
      text-shadow: 0 0 6px rgba(255, 200, 120, 0.5);
      margin-bottom: 10px;
    }

    .contenedor {
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(10px);
      border-radius: 12px;
      padding: 25px;
      width: 95%;
      max-width: 900px;
      box-shadow: 0 0 15px rgba(0,0,0,0.4);
      margin-bottom: 40px;
    }

    .buscador {
      text-align: center;
      margin-bottom: 20px;
    }

    .buscador input {
      padding: 8px 12px;
      width: 60%;
      max-width: 350px;
      border-radius: 8px;
      border: none;
      outline: none;
      font-size: 15px;
    }

    .buscador button {
      padding: 8px 15px;
      background-color: #d9a46e;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      color: #fff;
      font-weight: bold;
      margin-left: 5px;
      transition: 0.3s;
    }

    .buscador button:hover {
      background-color: #c68c58;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      color: #fff;
    }

    th, td {
      padding: 10px;
      text-align: left;
    }

    th {
      background-color: rgba(255, 255, 255, 0.1);
      color: #ffcc88;
    }

    tr:nth-child(even) {
      background-color: rgba(255, 255, 255, 0.05);
    }

    .acciones a {
      text-decoration: none;
      color: #fff;
      padding: 6px 10px;
      border-radius: 6px;
      font-size: 14px;
      margin: 0 3px;
    }

    .editar {
      background-color: #4caf50;
    }

    .editar:hover {
      background-color: #45a049;
    }

    .eliminar {
      background-color: #e74c3c;
    }

    .eliminar:hover {
      background-color: #c0392b;
    }

    .volver {
      text-decoration: none;
      display: inline-block;
      padding: 10px 15px;
      background-color: #ffcc88;
      color: #000;
      border-radius: 8px;
      margin-top: 20px;
      font-weight: bold;
      transition: 0.3s;
    }

    .volver:hover {
      background-color: #f0b85e;
    }

    footer {
      text-align: center;
      padding: 15px;
      font-size: 14px;
      color: #c8b9a6;
    }

    /* Responsive */
    @media (max-width: 600px) {
      table, th, td {
        font-size: 13px;
      }

      .buscador input {
        width: 80%;
      }

      .contenedor {
        padding: 15px;
      }
    }
  </style>
</head>
<body>
  <header>
    <h1>☕ Administrar Administradores</h1>
    <p>Monitorea, edita o elimina cuentas de administrador</p>
  </header>

  <div class="contenedor">
    <div class="buscador">
      <form method="GET">
        <input type="text" name="buscar" placeholder="Buscar por nombre o correo..." value="<?php echo htmlspecialchars($busqueda); ?>">
        <button type="submit">Buscar</button>
        <a href="gestionar_admin.php" class="volver" style="margin-left:10px;">Mostrar Todo</a>
      </form>
    </div>

    <table>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Correo</th>
        <th>Contraseña (encriptada)</th>
        <th>Acciones</th>
      </tr>
      <?php while($fila = $resultado->fetch_assoc()): ?>
        <tr>
          <td><?php echo $fila['id']; ?></td>
          <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
          <td><?php echo htmlspecialchars($fila['correo']); ?></td>
          <td style="font-size:12px;"><?php echo substr($fila['contrasena'], 0, 25) . '...'; ?></td>
          <td class="acciones">
            <a class="editar" href="editar_admin.php?id=<?php echo $fila['id']; ?>">Editar</a>
            <a class="eliminar" href="gestionar_admin.php?eliminar=<?php echo $fila['id']; ?>" onclick="return confirm('¿Seguro que deseas eliminar este administrador?');">Eliminar</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  </div>

  <a href="Menu_admin.html" class="volver">⬅ Volver al Panel Principal</a>

  <footer>
    © 2025 Cafetería LenSaYa | Panel Administrativo
  </footer>
</body>
</html>
<?php $conexion->close(); ?>
