<?php
require("../conector/cn.php");

$usuario_id = $_REQUEST['usuario_id'];
$sql = "SELECT * FROM usuarios WHERE usuario_id = '$usuario_id'";
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="estilos/editar.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <title>Forlaik</title>
</head>

<body>
  <div class="container">
    <!-- Aquí van tus imágenes, asegúrate de que las rutas estén correctas -->
    <img src="images/Recurso 58.png" class="banner" alt="banner">
    <img src="images/Recurso 52.png" alt="logo" class="logo">

    <div id="datos">
      Datos

    </div>
    <form action="editardata.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="usuario_id" value="<?php echo $fila['usuario_id']; ?>">

      <div class="perfil-usuario">
        <img class="imagen-perfil" src="data:image/jpg;base64,<?php echo base64_encode($fila['fotousuario']); ?>" alt="Imagen del usuario">
        <label for="ImagenTelefono" class="icono-camara">
          <i class="fas fa-camera"></i> <!-- Icono de cámara -->
        </label>
        
    <input type="file" id="ImagenTelefono" name="ImagenTelefono" accept=".jpg, .jpeg" style="display: none;" onchange="previewImage(event)">

      </div>

      <div id="demoFont"><strong>
          <center><?= "Editar datos " ?></center>
        </strong></div>

      <br>
      <br>

      <div id="nombre">
        <div id="titulo" class="fila-flex">
          <strong>Nombre: </strong>
          <input type="text" class="form-control input-datos" id="nombre" name="nombre" aria-describedby="emailHelp" value="<?php echo $fila['nombre']; ?>">

        </div>
        <br>

        <div id="titulo" class="fila-flex">
          <strong>Apellido: </strong>
          <input type="text" class="form-control input-datos" id="apellido" name="apellido" aria-describedby="emailHelp" value="<?php echo $fila['apellido']; ?>">

        </div>

        <br>

        <div id="titulo" class="fila-flex">
          <strong>Dirección: </strong>
          <input type="text" class="form-control input-datos" id="direccion" name="direccion" aria-describedby="emailHelp" value="<?php echo $fila['direccion']; ?>">

        </div>

        <br>

        <div id="titulo" class="fila-flex">
          <strong>Teléfono: </strong>
          <input type="text" class="form-control input-datos" id="telefono" name="telefono" aria-describedby="emailHelp" value="<?php echo $fila['telefono']; ?>">

        </div>

        <br>

        <div id="titulo" class="fila-flex">
          <strong>Correo: </strong>
          <input type="text" class="form-control input-datos" id="correo" name="correo" aria-describedby="emailHelp" value="<?php echo $fila['correo']; ?>">

        </div>

        <br>

        <div class="contenedor-botones">
          <input type="image" src="images/boton editar.png" alt="Submit" class="boton elemento">
          <a href="perfil.php" class="elemento">
            <img src="images/Recurso 18.png" alt="Recurso-18" class="boton-salir" width="150px" height="auto">
          </a>
        </div>





    </form>


  </div>

  <script>
    function previewImage(event) {
      var reader = new FileReader();
      var imageField = document.querySelector('.imagen-perfil');

      reader.onload = function () {
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