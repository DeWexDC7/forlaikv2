<?php
session_start();

// Incorporar el conector de la base de datos
require "cn.php"; // Verifica que la conexión esté configurada correctamente en este archivo

// Validar si se ha enviado información
if (!isset($_POST['usuario'], $_POST['contraseña'])) {
    header('Location: ../../login.php?error=1'); // Asumiendo que "login.php" está dos directorios arriba
    exit;
}

// Convertir la contraseña ingresada a MD5 (MD5 es inseguro, considera usar funciones de hash más seguras)
$contrasenaMD5 = md5($_POST['contraseña']);

// Preparar la consulta SQL para evitar inyecciones SQL
if ($stmt = $conn->prepare('SELECT usuario_id, contraseña FROM usuarios WHERE usuario = ?')) {
    $stmt->bind_param('s', $_POST['usuario']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($usuario_id, $contraseña_guardada);
        $stmt->fetch();

        if ($contrasenaMD5 === $contraseña_guardada) {
            // Inicio de sesión exitoso, se establecen las variables de sesión
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['usuario'];
            $_SESSION['usuario_id'] = $usuario_id; // Cambiando la clave a 'usuario_id' para consistencia
            header('Location: ../datosclientes/perfil.php'); // Redirige a la página de inicio
            exit;
        } else {
            $_SESSION['error_msg'] = "Usuario o contraseña incorrectos";
            header('Location: ../datosclientes/login.php'); // Redirige de nuevo al login
            exit;
        }
    } else {
        $_SESSION['error_msg'] = "Usuario o contraseña incorrectos";
        header('Location: ../datosclientes/login.php?error=credenciales_incorrectas');
        exit;
    }

    $stmt->close();
} else {
    // No se pudo preparar la consulta SQL
    exit('Error al preparar la consulta: ' . htmlspecialchars($conn->error));
}
?>
