
<?php
// Iniciar la sesión si no ha sido iniciada ya.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Deshacer la sesión.
$_SESSION = array();

// Si se desea destruir la sesión completamente, se podría borrar también la cookie de sesión.
// Nota: ¡Esto destruirá la sesión, y no solo los datos de sesión!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Finalmente, destruir la sesión.
session_destroy();

// Después de cerrar la sesión, usualmente se redirige al usuario a la página principal o a la página de inicio de sesión.
header("Location: ../datosclientes/login.php"); // Ajusta esto a la ruta correcta si es diferente.
exit;
?>
