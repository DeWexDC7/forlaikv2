<?php
require("../conector/cn.php");

session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../../index.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

function resizeImage($originalImage, $toWidth, $toHeight) {
    $srcWidth = imagesx($originalImage);
    $srcHeight = imagesy($originalImage);

    $dstImg = imagecreatetruecolor($toWidth, $toHeight);
    imagecopyresampled($dstImg, $originalImage, 0, 0, 0, 0, $toWidth, $toHeight, $srcWidth, $srcHeight);
    return $dstImg;
}

$target_dir = "uploads/";
$mascota_id = $_POST['mascota_id'];
$nombre_mascota = $_POST['nombre_mascota'];
$raza = $_POST['raza'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];

$sql = "UPDATE mascotas SET  
            nombre_mascota='".$nombre_mascota."',
            raza='".$raza."',
            fecha_nacimiento='".$fecha_nacimiento."'";

if(isset($_FILES['ImagenTelefono']['tmp_name']) && $_FILES['ImagenTelefono']['tmp_name'] != '') {
    if($_FILES['ImagenTelefono']['error'] == 0) {
        $imgData = file_get_contents($_FILES['ImagenTelefono']['tmp_name']);
        $originalImage = imagecreatefromstring($imgData);
        $resizedImage = resizeImage($originalImage, 450, 450);

        ob_start();
        imagejpeg($resizedImage);
        $imgContent = ob_get_contents();
        ob_end_clean();

        $FotoMascota = addslashes($imgContent);

        $sql .= ", FotoMascota='".$FotoMascota."'";
    }
}

if(isset($_FILES['pdfFile']['tmp_name']) && $_FILES['pdfFile']['tmp_name'] != '') {
    if($_FILES['pdfFile']['error'] == 0) {
        $pdfName = basename($_FILES["pdfFile"]["name"]);
        $target_file = $target_dir . $pdfName;
        if(move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $target_file)) {
            $sql .= ", pdfLocation='".$target_file."'";
        }
    }
}

$sql .= " WHERE mascota_id ='".$mascota_id."'";

$query = mysqli_query($conn, $sql);

if($query) {
    echo "<script>alert('Datos editados'); window.location.href = 'perfil.php?mascota_id=" . $mascota_id . "';</script>";
} else {
    echo "Error en la actualización: " . mysqli_error($conn);
}
?>
