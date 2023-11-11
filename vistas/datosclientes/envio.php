<?php
// Incluir tu script de conexión
include '../conector/cn.php'; // Cambia esto por la ruta correcta a tu script de conexión

// Verificar si se ha enviado el archivo
if (isset($_FILES['fotousuario'])) {
    // El directorio donde se almacenará la imagen. Asegúrate de que este directorio sea escribible por el servidor web.
    $target_dir = "uploads/";

    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($conn, $_POST['apellido']);
    $telefono = mysqli_real_escape_string($conn, $_POST['telefono']);
    $correo = mysqli_real_escape_string($conn, $_POST['correo']);
    $direccion = mysqli_real_escape_string($conn, $_POST['direccion']);
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $contraseña = mysqli_real_escape_string($conn, $_POST['contraseña']); // Nota: considera encriptar la contraseña

    // Obtener datos del archivo
    $file_name = $_FILES['fotousuario']['name'];
    $file_tmp = $_FILES['fotousuario']['tmp_name'];
    $file_size = $_FILES['fotousuario']['size'];

    // Verificar si el archivo es una imagen
    if (getimagesize($file_tmp)) {
        // Limitar el tipo de archivo y el tamaño
        $allowed_types = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
        $detected_type = exif_imagetype($file_tmp);
        $error = !in_array($detected_type, $allowed_types);
        $max_file_size = 500000; // Aquí puedes establecer el tamaño máximo del archivo. Este es un ejemplo.

        if (!$error && $file_size <= $max_file_size) {
            // Todo está bien, proceder a guardar la imagen en la base de datos.

            // Leer el contenido del archivo
            $imgContent = addslashes(file_get_contents($file_tmp));

            // Crear consulta SQL
            $sql = "INSERT INTO usuarios (nombre, apellido, telefono, correo, direccion, usuario, contraseña, fotousuario) VALUES ('$nombre', '$apellido', '$telefono', '$correo', '$direccion', '$usuario', md5('$contraseña'), '$imgContent')";



            // Ejecutar la consulta y verificar el éxito
            if (mysqli_query($conn, $sql)) {

                echo "<script>alert('Usuario Registrado');window.location.href = 'login.php';
     ;</script>";
            } else {
                echo "<script>alert('Usuario no Registrado');window.location.href = 'registro.php';
                ;</script>";
            }
        } else {
            // El archivo no cumple con los requisitos de seguridad o es demasiado grande
            echo "Error: el archivo no es válido o es demasiado grande.";
        }
    } else {
        echo "Error: el archivo subido no es una imagen.";
    }
} else {
    echo "Error: no se subió ningún archivo.";
}
