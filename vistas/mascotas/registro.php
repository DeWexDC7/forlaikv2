<?php

require("../conector/cn.php");
// confirmar sesion

session_start();


if (!isset($_SESSION['loggedin'])) {

    header('Location: ../datosclientes/login.php');
    exit;
}
?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="estilos/registro.css">
    <!-- CSS de SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <!-- JS de SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <title>Forlaik</title>
</head>

<body>
    <div class="container">
        <img src="images/Recurso 58.png" class="banner" alt="banner">
        <img src="images/Recurso 52.png" alt="logo" class="logo">

        <div id="datos">
            Datos
        </div>
        <form action="envio.php" method="POST" enctype="multipart/form-data">
            <div class="upload-btn-wrapper">
                <label for="upload-file" class="custom-file-upload" id="image-preview">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-fill" viewBox="0 0 16 16">
                        <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                        <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z" />
                    </svg> <!-- Este es tu ícono de cámara, puede ser cualquier ícono que elijas -->
                </label>
                <input id="upload-file" type="file" name="FotoMascota" accept=".jpg" require />
            </div>


            <?php

            $def2 = $_SESSION['usuario_id'];
            $sql2 = "Select * from usuarios where usuario_id=$def2";
            $result2 = mysqli_query($conn, $sql2);
            $fila2 = mysqli_fetch_array($result2);

            ?>

            <div id="demoFont"><strong>

                    <center><?= "Bienvenido " . $fila2['nombre']; ?></center>
                </strong>
            </div>

            <br>
            <br>
            <br>

            <div id="nombre">
                <div id="titulo" class="fila-flex">
                    <strong>Nombre de la mascota : </strong>

                    <input type="text" class="form-control entrada-uniforme" id="exampleFormControlInput1" name="nombre_mascota" require>
                </div>
                <br>

                <div id="titulo" class="fila-flex">
                    <strong>Raza de la mascota: </strong>
                    <br>
                    <input type="text" class="form-control entrada-uniforme" id="exampleFormControlInput1" name="raza" require>

                </div>

                <br>

                <div id="titulo" class="fila-flex">
                    <strong>Fecha de nacimiento: </strong>
                    <br>
                    <input type="date" class="form-control entrada-uniforme" id="exampleFormControlInput1" name="fecha_nacimiento" require>

                </div>
                <br>
                <div id="titulo" class="fila-flex">
                    <strong>Historial clínico: </strong>
                    <br>
                    <input type="file" class="form-control  entrada-uniforme" name="pdfFile" accept=".pdf">
                </div>



                <br><br><br>

                <center>
                    <input type="image" src="../../assets/Recurso 19.png" alt="Submit" width="auto" height="60px" require>
                </center>


                <br>
        </form>



    </div>

    <!-- Aquí va tu script de JavaScript -->
    <script>
        document.getElementById("upload-file").onchange = function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var imagePreview = document.getElementById('image-preview');
                imagePreview.style.backgroundImage = 'url(' + reader.result + ')';

                // Aquí, ocultamos el ícono de la cámara después de que se carga una imagen
                var icon = document.querySelector('.icon');
                icon.style.display = 'none';
            };
            reader.readAsDataURL(event.target.files[0]);
        };
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