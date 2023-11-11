<?php
session_start();
include("../conector/cn.php");

$nombre_mascota = $_POST['nombre_mascota'];
$raza = $_POST['raza'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];

if(isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];
} else {
    die("Error: El usuario no está definido en la sesión.");
}

// ... (código para procesar la imagen y el archivo PDF) ...
// Procesar la imagen y redimensionarla.
$FotoMascota = '';
if(isset($_FILES['FotoMascota']['tmp_name']) && $_FILES['FotoMascota']['tmp_name'] != ''){
    // Ruta temporal de la imagen subida
    $uploadedImage = $_FILES['FotoMascota']['tmp_name'];

    // Obtener las dimensiones de la imagen
    list($source_width, $source_height) = getimagesize($uploadedImage);

    // Definir las dimensiones deseadas
    $new_width = 450;
    $new_height = 450;

    // Crear un "lienzo" en blanco para la nueva imagen
    $new_image = imagecreatetruecolor($new_width, $new_height);

    // Cargar la imagen subida
    $source_image = imagecreatefromjpeg($uploadedImage);

    // Redimensionar la imagen
    imagecopyresampled($new_image, $source_image, 0, 0, 0, 0, $new_width, $new_height, $source_width, $source_height);

    // Guardar la imagen redimensionada en una variable para después guardarla en la base de datos
    ob_start();
    imagejpeg($new_image);
    $image_data = ob_get_contents();
    ob_end_clean();

    // Liberar memoria
    imagedestroy($source_image);
    imagedestroy($new_image);

    // Convertir la imagen a un formato que puedas guardar en la base de datos
    $FotoMascota = addslashes($image_data);}

// Definir directorio de subida
$target_dir = "uploads/";

// Procesar el archivo PDF
$pdfLocation = '';
if(isset($_FILES['pdfFile']['tmp_name']) && $_FILES['pdfFile']['tmp_name'] != ''){
    $target_file = $target_dir . basename($_FILES["pdfFile"]["name"]);
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if($fileType != "pdf") {
        echo "Lo sentimos, solo se permiten archivos PDF.";
        exit;
    }
    
    if (move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $target_file)) {
        $pdfLocation = $target_file;
    } else {
        echo "Hubo un error al subir tu archivo.";
        exit;
    }
}
// Asumiendo que sólo hay un collar no registrado por usuario o que se selecciona de alguna manera.
$consulta_collar = "SELECT collar_id, serial_nfc FROM collaresnfc WHERE registrado = 0 LIMIT 1"; // Ajusta la consulta si tienes una lógica de selección diferente.
$resultado_collar = mysqli_query($conn, $consulta_collar);

if (mysqli_num_rows($resultado_collar) > 0) {
    $fila = mysqli_fetch_assoc($resultado_collar);
    $collar_id = $fila['collar_id'];
    $serial_nfc = $fila['serial_nfc']; // No es necesario para el insert, pero podría ser útil para la lógica adicional.

    // Registrar la mascota
    $sql = "INSERT INTO mascotas (nombre_mascota, raza, fecha_nacimiento, FotoMascota, usuario_id, collar_id, pdfLocation) 
            VALUES ('$nombre_mascota', '$raza', '$fecha_nacimiento', '$FotoMascota', '$usuario_id', '$collar_id', '$pdfLocation')";

    $resultado = mysqli_query($conn, $sql);

    if (!$resultado) {
        echo "Error en la inserción: " . mysqli_error($conn);
    } else {
        // Actualizar el estado del collar a 'registrado'
        $actualizar_collar = "UPDATE collaresnfc SET registrado = 1 WHERE collar_id = '$collar_id'";
        if(mysqli_query($conn, $actualizar_collar)) {
            echo "<script>
                    alert('Mascota registrada con éxito');
                    window.location.href = '../datosclientes/listamascota.php';
                  </script>";
        } else {
            echo "Error al actualizar el estado del collar: " . mysqli_error($conn);
        }
    }
} else {
    echo "<script>
    alert('No hay collares disponbiles para su registro');
    window.location.href = '../datosclientes/listamascota.php';
  </script>";

}

mysqli_close($conn);
