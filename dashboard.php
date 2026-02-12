<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel - Cafetería LenSaYa</title>
  <style>
    /* === Estilos Base Responsive === */
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

    /* === Teléfonos Móviles (hasta 480px) === */
    @media (max-width: 480px) {
      body {
        padding: 15px;
        min-height: 100vh;
      }

      .contenedor {
        padding: 25px 20px;
        border-radius: 15px;
        margin: 10px;
      }

      h2 {
        font-size: 1.6rem;
        margin-bottom: 15px;
      }

      p {
        font-size: 1.1rem;
        margin-bottom: 25px;
      }

      .btn {
        padding: 12px 30px;
        font-size: 1.1rem;
        width: 100%;
        max-width: 280px;
      }
    }

    /* === Tablets Pequeñas (481px - 600px) === */
    @media (min-width: 481px) and (max-width: 600px) {
      .contenedor {
        padding: 30px 25px;
        border-radius: 18px;
        margin: 15px;
      }

      h2 {
        font-size: 1.8rem;
      }

      p {
        font-size: 1.2rem;
      }

      .btn {
        padding: 14px 35px;
        font-size: 1.15rem;
      }
    }

    /* === Tablets (601px - 768px) === */
    @media (min-width: 601px) and (max-width: 768px) {
      .contenedor {
        padding: 35px 30px;
        max-width: 450px;
      }

      h2 {
        font-size: 2rem;
      }

      p {
        font-size: 1.25rem;
      }
    }

    /* === Laptops Pequeñas (769px - 1024px) === */
    @media (min-width: 769px) and (max-width: 1024px) {
      .contenedor {
        max-width: 500px;
        padding: 40px 35px;
      }

      h2 {
        font-size: 2.1rem;
      }

      p {
        font-size: 1.3rem;
      }

      .btn {
        padding: 16px 45px;
        font-size: 1.25rem;
      }
    }

    /* === Computadoras de Escritorio (1025px - 1440px) === */
    @media (min-width: 1025px) and (max-width: 1440px) {
      .contenedor {
        max-width: 550px;
        padding: 45px 40px;
      }

      h2 {
        font-size: 2.3rem;
      }

      p {
        font-size: 1.4rem;
      }

      .btn {
        padding: 18px 50px;
        font-size: 1.3rem;
      }
    }

    /* === Pantallas Grandes (más de 1440px) === */
    @media (min-width: 1441px) {
      .contenedor {
        max-width: 600px;
        padding: 50px 45px;
      }

      h2 {
        font-size: 2.5rem;
      }

      p {
        font-size: 1.5rem;
      }

      .btn {
        padding: 20px 60px;
        font-size: 1.4rem;
      }
    }

    /* === Modo Landscape en Móviles === */
    @media (max-height: 500px) and (orientation: landscape) {
      body {
        padding: 10px;
        min-height: auto;
        height: auto;
      }

      .contenedor {
        padding: 20px 25px;
        margin: 5px;
      }

      h2 {
        font-size: 1.5rem;
        margin-bottom: 10px;
      }

      p {
        font-size: 1rem;
        margin-bottom: 15px;
      }

      .btn {
        padding: 10px 25px;
        font-size: 1rem;
      }
    }

    /* === Alto Contraste para Accesibilidad === */
    @media (prefers-contrast: high) {
      .contenedor {
        border: 3px solid #000;
      }

      h2, p {
        color: #000;
      }

      .btn {
        background: #000;
        color: #fff;
      }
    }

    /* === Modo Reducido Movimiento === */
    @media (prefers-reduced-motion: reduce) {
      .btn {
        transition: none;
        transform: none;
      }

      .btn:hover {
        transform: none;
      }
    }
  </style>
</head>
<body>
  <div class="contenedor">
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></h2>
    <p>Has iniciado sesión correctamente.</p>
    <a href="logout.php" class="btn">Ingresar</a>
  </div>
</body>
</html>