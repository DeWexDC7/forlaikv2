<?php
require("../conector/cn.php");
$mascota_id = $_REQUEST['mascota_id'];

$sql = "SELECT * from mascotas where mascota_id = '$mascota_id'";

$query = mysqli_query($conn, $sql);
$fila = mysqli_fetch_array($query);
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="estilos/editar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha384-1FKOq4bDz4vdmAFm3z8E9N7Zw7tjcEfP5hi1z8Q6w6CkZvnK1oFHmZr6CoMwBP60" crossorigin="anonymous">


    <title>Forlaik</title>
</head>

<body>
    <div class="container">
        <img src="images/Recurso 58.png" class="banner" alt="banner">
        <a href="../datosclientes/perfil.php"><img src="images/Recurso 52.png" alt="logo" class="logo"></a>
        <div id="datos">
            Datos
        </div>
        <form action="editardata.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="mascota_id" value="<?php echo $fila['mascota_id']; ?>">

            <div class="perfil-usuario">
                <img class="imagen-perfil" src="data:image/jpg;base64,<?php echo base64_encode($fila['FotoMascota']); ?>" alt="Imagen del usuario">
                <label for="ImagenTelefono" class="icono-camara">
                    <i class="fas fa-camera"></i> <!-- This is the camera icon from Font Awesome -->
                </label>
                <input type="file" id="ImagenTelefono" name="ImagenTelefono" accept="image/*" style="display: none;" onchange="previewImage(event)">

            </div>

            <div id="demoFont"><strong>
                    <center><?= "Editar datos " ?></center>
                </strong></div>

            <br>
            <br>

            <div id="nombre">
                <div id="titulo" class="fila-flex">
                    <strong>Nombre de la mascota: </strong>
                    <input type="text" class="form-control input-datos" id="nombre_mascota" name="nombre_mascota" aria-describedby="emailHelp" value="<?php echo $fila['nombre_mascota']; ?>">

                </div>
                <br>

                <div id="titulo" class="fila-flex">
                    <strong>Raza de la mascota: </strong>
                    <input type="text" class="form-control input-datos" id="raza" name="raza" aria-describedby="emailHelp" value="<?php echo $fila['raza']; ?>">

                </div>

                <br>

                <div id="titulo" class="fila-flex">
                    <strong>Fecha de nacimiento: </strong>
                    <input type="text" class="form-control input-datos" id="fecha_nacimiento" name="fecha_nacimiento" aria-describedby="emailHelp" value="<?php echo $fila['fecha_nacimiento']; ?>">

                </div>

                <br>

                <div id="titulo" class="fila-flex">
                    <label for="exampleInputEmail1" class="form-label"><strong>Historial Clinico: </strong></label>
                    <input type="File" class="form-control input-datos" name="pdfFile" accept=".pdf">
                </div>

                <br>


                    <div id="locate" class="fila-flex">
                    <?php echo $fila['pdfLocation']; ?>
                    </div>



                <br>

                <div class="contenedor-botones">
                    <input type="image" src="images/boton editar.png" alt="Submit" class="boton elemento">
                    <a href="perfil.php?mascota_id=<?php echo $fila['mascota_id'] ?>">
                        <img src="images/Recurso 18.png" alt="Recurso-18" class="boton-salir" width="150px" height="auto">
                    </a>
                </div>

        </form>


    </div>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            var imageField = document.querySelector('.imagen-perfil');

            reader.onload = function() {
                if (reader.readyState == 2) {
                    imageField.src = reader.result;
                }
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
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