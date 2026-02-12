<?php
include 'conexion.php';
$consulta = "SELECT * FROM usuarios";
$resultado = $conexion->query($consulta);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Usuarios | Panel</title>
  <link rel="stylesheet" href="gestionar_usuarios.css">
</head>
<body>

  <div class="contenedor">
    <h2>👤 Panel de Usuarios</h2>

    <input type="text" id="buscar" placeholder="🔍 Buscar usuario..." class="buscador">

    <table id="tablaUsuarios">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Apellido Paterno</th>
          <th>Apellido Materno</th>
          <th>Teléfono</th>
          <th>Correo</th>
          <th>Fecha Registro</th>
          <th>Token</th>
          <th>Expira</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
          <tr>
            <td><?= $fila['id'] ?></td>
            <td contenteditable="true" class="editable"><?= $fila['nombre'] ?></td>
            <td contenteditable="true" class="editable"><?= $fila['apellido_paterno'] ?></td>
            <td contenteditable="true" class="editable"><?= $fila['apellido_materno'] ?></td>
            <td contenteditable="true" class="editable"><?= $fila['telefono'] ?></td>
            <td contenteditable="true" class="editable"><?= $fila['correo'] ?></td>
            <td><?= $fila['fecha_registro'] ?></td>
            <td><?= $fila['recupera_token'] ?></td>
            <td><?= $fila['recupera_expira'] ?></td>
            <td>
              <button class="guardar-btn" onclick="guardarCambios(this, <?= $fila['id'] ?>)">💾</button>
              <button class="eliminar-btn" onclick="eliminarUsuario(<?= $fila['id'] ?>)">🗑️</button>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

<script>
// === Buscador dinámico ===
document.getElementById('buscar').addEventListener('keyup', function() {
  const filtro = this.value.toLowerCase();
  const filas = document.querySelectorAll('#tablaUsuarios tbody tr');
  filas.forEach(fila => {
    const texto = fila.textContent.toLowerCase();
    fila.style.display = texto.includes(filtro) ? '' : 'none';
  });
});

// === Guardar cambios ===
function guardarCambios(boton, id) {
  const fila = boton.closest('tr');
  const celdas = fila.querySelectorAll('.editable');
  const datos = {
    id,
    nombre: celdas[0].textContent.trim(),
    apellido_paterno: celdas[1].textContent.trim(),
    apellido_materno: celdas[2].textContent.trim(),
    telefono: celdas[3].textContent.trim(),
    correo: celdas[4].textContent.trim()
  };

  fetch('actualizar_usuario.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify(datos)
  }).then(r => r.text()).then(respuesta => {
    alert('✅ ' + respuesta);
  });
}

// === Eliminar usuario ===
function eliminarUsuario(id) {
  if (confirm('¿Seguro que deseas eliminar este usuario?')) {
    fetch('eliminar_usuarios.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify({ id })
    }).then(r => r.text()).then(respuesta => {
      alert('🗑️ ' + respuesta);
      location.reload();
    });
  }
}
</script>

</body>
</html>

<?php $conexion->close(); ?>
