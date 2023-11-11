<?php
require("../conector/cn.php");

// Obtener el ID de la mascota del parámetro de la URL y asegurarse de que es un entero
$mascota_id = isset($_GET['mascota_id']) ? intval($_GET['mascota_id']) : die("Error: no se proporcionó el ID de la mascota.");

// Consulta SQL para obtener detalles de la mascota basados en mascota_id
$sql = "SELECT 
    m.nombre_mascota, 
    m.raza, 
    m.fecha_nacimiento, 
    m.pdfLocation,
    m.FotoMascota,
    u.nombre, 
    u.contraseña, 
    u.direccion, 
    u.telefono, 
    u.correo
FROM 
    mascotas m
INNER JOIN 
    usuarios u ON m.usuario_id = u.usuario_id 
WHERE 
    m.mascota_id = $mascota_id";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 0) {
    die('No se encontró la mascota con el ID proporcionado.');
}

$fila = mysqli_fetch_assoc($result);
$pdf = $fila['pdfLocation'];

// ... Resto del código HTML/PHP que presenta la información ...
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="estilos/perfil.css">
    <title>Forlaik</title>
    

</head>

<body>
    <div class="container">
        <img src="images/Recurso50.png" alt="Recurso50" class="img-fluid img-fluid custom-img" border="0" />
      <a href="../datosclientes/perfil.php">  <img src="images/Recurso56.png" alt="Recurso-56" class="logo" border="0"></a>
       

<div id="perfil">
    <strong>Perfil</strong>
</div>

        <img src="data:image/png;base64,<?= base64_encode($fila['FotoMascota']) ?>" class="profile-picture" alt="Imagen de la Usuario">


        <div id="demoFont"><strong>
                <center><?= "Bienvenido " . $fila['nombre'] ?></center>
            </strong></div>



        <hr>

        <div id="nombre">
            <div id="titulo">
                Nombre de la Mascota

            </div>

            <div id="familia">
                <?= $fila['nombre_mascota'] ?> 

            </div>
            <br>

            <div id="titulo">
                Raza
            </div>

            <div id="familia">
                <?= $fila['raza'] ?>
            </div>

            <br>

            <div id="titulo">
                Fecha de Nacimiento
            </div>

            <div id="familia">
                <?= $fila['fecha_nacimiento'] ?>
            </div>

            <br>

          
        </div>


        <hr>




        
        <div class="contenedor-botones">

            <a href="editarmascota.php?mascota_id=<?php echo $mascota_id ?>"><img src="images/boton editar.png" alt="Recurso-18" class="boton-salir" border="0"></a>

        
            <a href="../login/cerrarsesion.php"><img src="images/Recurso 18.png" alt="Recurso-18" class="boton-salir" border="0"></a>
        </div>
        <br>

    </div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>