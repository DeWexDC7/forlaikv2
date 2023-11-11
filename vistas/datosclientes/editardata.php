<?php
require("../conector/cn.php");

session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../../index.php');
    exit;
}

// Asumimos que 'usuario_id' fue almacenado en la sesión durante el inicio de sesión
$usuario_id = $_SESSION['usuario_id'];

function resizeImage($originalImage, $toWidth, $toHeight) {
    $srcWidth = imagesx($originalImage);
    $srcHeight = imagesy($originalImage);

    $dstImg = imagecreatetruecolor($toWidth, $toHeight);
    imagecopyresampled($dstImg, $originalImage, 0, 0, 0, 0, $toWidth, $toHeight, $srcWidth, $srcHeight);
    return $dstImg;
}


// Comprobamos si hay una foto enviada
if(isset($_FILES['ImagenTelefono']) && $_FILES['ImagenTelefono']['error'] == 0){
    $imagen = $_FILES['ImagenTelefono']['tmp_name'];
    $imgContent = addslashes(file_get_contents($imagen));
} else {
    $imgContent = null;
}

// Variables del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];

// Preparamos la consulta para actualizar la información
if($imgContent){
    // Si hay una imagen, actualizamos también la columna de la imagen
    $sql = "UPDATE usuarios SET 
        nombre = '$nombre',
        apellido = '$apellido',
        direccion = '$direccion',
        telefono = '$telefono',
        correo = '$correo',
        fotousuario = '$imgContent'
        WHERE usuario_id = '$usuario_id'";
} else {
    // Si no hay imagen, no actualizamos la columna de la imagen
    $sql = "UPDATE usuarios SET 
        nombre = '$nombre',
        apellido = '$apellido',
        direccion = '$direccion',
        telefono = '$telefono',
        correo = '$correo'
        WHERE usuario_id = '$usuario_id'";
}

if(mysqli_query($conn, $sql)){
    // Si la actualización fue exitosa, redirigimos al usuario a su perfil o a una página de confirmación
    header('Location: perfil.php');
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
?>
