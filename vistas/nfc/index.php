<?php
require("../conector/cn.php");

if (isset($_GET['serial_nfc'])) {
    $serial_nfc = mysqli_real_escape_string($conn, $_GET['serial_nfc']);

    $sql = "SELECT 
                m.FotoMascota, 
                UPPER(m.nombre_mascota) AS nombre_mascota,
                CONCAT(UPPER(SUBSTRING(u.nombre, 1, 1)), LOWER(SUBSTRING(u.nombre, 2))) AS nombre,
                CONCAT(UPPER(SUBSTRING(u.apellido, 1, 1)), LOWER(SUBSTRING(u.apellido, 2))) AS apellido,
                u.fotousuario,
                u.direccion,
                u.correo,
                u.telefono,
                m.pdfLocation
            FROM 
                collaresnfc AS c
            JOIN 
                mascotas AS m ON c.collar_id = m.collar_id
            JOIN 
                usuarios AS u ON m.usuario_id = u.usuario_id
            WHERE 
                c.serial_nfc = '$serial_nfc' AND c.registrado = 1;";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $fila = mysqli_fetch_assoc($result);
        // Mostrar el HTML y los datos obtenidos de la base de datos
?>
        <!doctype html>
        <html lang="en">

        <head>
            <!-- Required meta tags -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <!-- Bootstrap CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
            <link rel="stylesheet" type="text/css" href="estilo/vista.css">
            <title>Forlaik</title>

            <script type="text/javascript">
                document.addEventListener('DOMContentLoaded', function() {
                    var cerrarBoton = document.querySelector('.boton-salir');

                    cerrarBoton.addEventListener('click', function() {
                        window.close();
                    });
                });
            </script>


        </head>

        <body>
            <div class="container">
                <img src="images/Recurso50.png" alt="Recurso50" class="img-fluid img-fluid custom-img" border="0" />
                <a href="index.php?serial_nfc=<?php echo $serial_nfc ?>"><img src="images/Recurso56.png" alt="Recurso-56" class="logo" border="0"></a>
                <div id="perfil">
                    Perfil
                </div>
                <img src="data:image/jpg;base64,<?= base64_encode($fila['FotoMascota']) ?>" class="profile-picture" alt="Imagen de la Mascota">


                <img src="images/Recurso 10.png" alt="Recurso-10" class="imagen-pequenia" border="0">
                <div id="demoFont"><strong>
                        <center><?= $fila['nombre_mascota'] ?></center>
                    </strong></div>

                <div id="familia">
                    <center>Familia <?= $fila['apellido'] ?><center>
                </div>

                <hr>
                <div class="img-row">

                    <a href="datos.php?serial_nfc=<?php echo $serial_nfc ?>" target="_blank"> <img src="images/Recurso 5.png" alt="Recurso-5" border="0 style=" cursor:pointer;" class="imagen_datos"></a>





                    <a href="<?= "../mascotas/" . $pdf ?>" target="_blank"> <img src="images/Recurso 4.png" alt="Recurso-4" border="0" style="cursor:pointer;" class="clinico"></a>
                    <a href="tel:+593<?php echo ltrim($fila['telefono'], '0'); ?>"><img src="images/Recurso 6.png" alt="Recurso-6" border="0" style="cursor:pointer;" class="llamada"></a>
                </div>
                <hr>



                <img src="images/Recurso 18.png" alt="Recurso-18" class="boton-salir" border="0" style="cursor:pointer;">

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
<?php
    } else {
        // Si el serial_nfc no está registrado o registrado es 0, redirigir a Google
        header("Location: ../datosclientes/registro.php");
        exit;
    }
} else {
    // Si el parámetro serial_nfc no está presente, puedes realizar alguna acción alternativa aquí si es necesario.
    echo "El parámetro serial_nfc no está presente en la URL.";
}
?>