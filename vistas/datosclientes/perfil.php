<?php
// Inicio de la sesión. Esto debe ir al comienzo de tu archivo.
session_start();

require("../conector/cn.php");

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    // Si no hay información de sesión, redirige a la página de inicio de sesión
    header("Location: login.php"); // Modifica esta ruta según corresponda
    exit();
}

// Procesamiento del formulario de verificación del código serial.
$error_message = ''; // Inicializar mensaje de error como una cadena vacía.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['serial_nfc'])) {
    $codigo_serial = $_POST['serial_nfc'];

    // Preparar la consulta SQL.
    $sql1 = "SELECT * FROM collaresnfc WHERE serial_nfc = ? AND registrado = 0";
    if ($stmt = mysqli_prepare($conn, $sql1)) {
        mysqli_stmt_bind_param($stmt, "s", $codigo_serial);
        if (mysqli_stmt_execute($stmt)) {
            $result1 = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result1) == 1) {
                // El código serial está disponible y no registrado.
                header("Location: ../mascotas/registro.php"); // Redirige al usuario a registro.php
                exit();
            } else {
                // El código serial no está disponible o ya está registrado.
                echo "<script>alert('El código serial ingresado no está disponible o ya ha sido registrado.');window.location.href = 'perfil.php';
                ;</script>";
            }
        } else {
            echo "<script>alert('Oops! Algo salió mal. Por favor inténtalo de nuevo más tarde.');window.location.href = 'perfil.php';
                ;</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        $error_message = "Oops! Algo salió mal al preparar la consulta. Por favor inténtalo de nuevo más tarde.";
    }
    // No cerrar la conexión aquí porque todavía puede ser necesaria para generar el resto de la página.
}

$usuario_id = $_SESSION['usuario_id']; // Obtener el ID del usuario de la sesión.

// Preparar la consulta SQL para evitar inyecciones de SQL y obtener los datos del usuario
$sql = "SELECT * FROM usuarios WHERE usuario_id = ?"; // Asumiendo que 'usuario_id' es el nombre correcto de tu columna de ID

// Preparar la declaración
if ($stmt = mysqli_prepare($conn, $sql)) {
    // Vincular variables a la declaración preparada como parámetros
    mysqli_stmt_bind_param($stmt, "i", $usuario_id);

    // Ejecutar la declaración
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        // Verificar si el usuario existe en la base de datos
        if (mysqli_num_rows($result) == 1) {
            // Usuario encontrado
            $fila = mysqli_fetch_assoc($result);
            // La variable $fila contiene ahora toda la información del usuario
        } else {
            // No se encontraron registros, manejar según sea necesario
            echo "No se encontró información para este usuario.";
            exit();
        }
    } else {
        echo "Oops! Algo salió mal. Por favor inténtalo de nuevo más tarde.";
        exit();
    }

    // Cerrar declaración
    mysqli_stmt_close($stmt);
} else {
    echo "Oops! Algo salió mal al preparar la consulta. Por favor inténtalo de nuevo más tarde.";
    exit();
}

// Cerrar conexión
mysqli_close($conn);

// A continuación, la estructura HTML se mantiene, y utilizas la información de $fila para mostrar los datos del usuario.
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="estilos/vista.css">
    <title>Forlaik</title>

</head>

<body>
    <div class="container">
        <img src="images/Recurso50.png" alt="Recurso50" class="img-fluid img-fluid custom-img" border="0" />
        <a href="perfil.php"><img src="images/Recurso56.png" alt="Recurso-56" class="logo" border="0"></a>

        <div id="perfil">
            Perfil

        </div>


        <img src="data:image/png;base64,<?= base64_encode($fila['fotousuario']) ?>" class="profile-picture" alt="Imagen de la Usuario">


        <div id="demoFont"><strong>
                <center><?= "Bienvenido " . $fila['nombre'] ?></center>
            </strong></div>



        <hr>

        <div id="nombre">
            <div id="titulo">
                Nombre y Apellido

            </div>

            <div id="familia">
                <?= $fila['nombre'] ?> <?= $fila['apellido'] ?>

            </div>
            <br>

            <div id="titulo">
                Dirección
            </div>

            <div id="familia">
                <?= $fila['direccion'] ?>
            </div>

            <br>

            <div id="titulo">
                Teléfono
            </div>

            <div id="familia">
                <?= $fila['telefono'] ?>
            </div>

            <br>

            <div id="titulo">
                Correo
            </div>

            <div id="familia">
                <?= $fila['correo'] ?>
            </div>

            <br>
            <div id="titulo">
                <a href="listamascota.php" target="_blank" rel="noopener noreferrer">Mascotas Registradas</a>
            </div>
        </div>


        <hr>

        <div style="display: flex; justify-content: space-between;">

            <a href="editar1.php?usuario_id=<?php echo $fila['usuario_id'] ?>"><img src="images/boton editar.png" alt="Recurso-18" class="boton-salir" border="0"></a>

            <!--Modal para ingreso de placa-->
            <img src="images/boton registrar .png" alt="Recurso-18" class="boton-registrar" data-bs-toggle="modal" data-bs-target="#exampleModal" border="0">

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                <div id="titulomodal">
                                    Forlaik
                                </div>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">
                                        <div id="instruccionmodal">
                                            Ingrese código serial
                                        </div>
                                    </label>
                                    <input type="text" class="form-control" name="serial_nfc" id="serial_nfc" aria-describedby="emailHelp">
                                    <div id="emailHelp" class="form-text">
                                        <div id="instrucciones">
                                            Estimado usuario <?= $fila['nombre'] ?> <?= $fila['apellido'] ?>, si desea registrar una mascota, por favor ingrese el código serial de su placa Forlaik.</div>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-prueba">Enviar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--Fin de modal-->

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