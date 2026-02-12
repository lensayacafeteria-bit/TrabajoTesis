<?php
$conexion = new mysqli("localhost", "root", "", "cafeteria_lensata");
if ($conexion->connect_error) {
  die("Error de conexión: " . $conexion->connect_error);
}

$sql = "SELECT * FROM admin";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
  while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>
      <td data-label='ID'>{$fila['id']}</td>
      <td data-label='Nombre'>{$fila['nombre']}</td>
      <td data-label='Correo'>{$fila['correo']}</td>
      <td data-label='Contraseña'>{$fila['contrasena']}</td>
      <td data-label='Tipo'>{$fila['tipo']}</td>
      <td>
        <button class='editar' onclick=\"window.location.href='editar_admin.php?id={$fila['id']}'\">Editar</button>
        <button class='eliminar' onclick='eliminarAdmin({$fila['id']})'>Eliminar</button>
      </td>
    </tr>";
  }
} else {
  echo "<tr><td colspan='6'>No hay administradores registrados.</td></tr>";
}

$conexion->close();
?>
