<?php
require("../conector/cn.php");

// Iniciar sesión y confirmar que el usuario ha iniciado sesión
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../../index.php');
    exit;
}

// Asumiendo que 'usuario_id' fue almacenado en la sesión durante el inicio de sesión
$usuario_id = $_SESSION['usuario_id']; // Asegúrate de que este es el nombre correcto para la clave de la sesión


// La consulta SQL para obtener todas las mascotas de este usuario
$sql = "SELECT 
            m.mascota_id,
            m.nombre_mascota, 
            m.raza, 
            m.fecha_nacimiento, 
            m.pdfLocation, 
            m.FotoMascota 
        FROM 
            mascotas m 
        WHERE 
            m.usuario_id = $usuario_id";

$result = mysqli_query($conn, $sql);

// Resto de tu código HTML/PHP para mostrar la información
// ...
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.2/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="estiloprincipal.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.2/js/dataTables.bootstrap5.min.js"></script>
    <title>Forlaik</title>
    <style>

        /* Estilos personalizados */
        body {
            background-color: #f5f5f5;
        }
        
        .navbar-brand {
            font-size: 1.5em; /* Aumentar el tamaño de la fuente del nombre de la aplicación */
        }

        .table {
            border-radius: 5px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra alrededor de la tabla */
        }

        .center-text {
            text-align: center;
            margin-top: 20px; /* Espaciado superior para el título */
            margin-bottom: 50px; /* Espaciado inferior para el título */
        }

        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: black; /* Cambiar colores de la paginación y labels si es necesario */
        }

        th, td {
            text-align: center; /* Centrar contenido de las celdas */
        }

        /* Opcional: Estilos para botones o enlaces en la tabla, como botones de acción */
        .btn-action {
            margin-right: 5px; /* Espaciado entre botones de acción */
        }


        
        .center-text {
            text-align: center;
        }

        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: #393D77;
            /* reemplaza 'tuColorDeseado' con el color que quieres, por ejemplo '#ff0000' para rojo */
        }

        .table-container {
            width: 70%; /* o cualquier porcentaje o valor fijo que prefieras */
            margin-left: auto;
            margin-right: auto;
        }

    </style>
</head>

<body>

    <body>
        <!-- Menu-->
        <nav class="navbar navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="perfil.php">
                    <img src="images/Recurso 44.png" alt="" width="60" height="auto" class="d-inline-block align-text-top">
                    
                </a>
                <a href="logout.php" class="btn btn-primary">Cerrar Sesión</a>
            </div>
        </nav>

        <!-- Fin de Menu -->
        <br><br>
        <div class="center-text">
            <h2><strong>
                    <font color="black">Mascotas Registradas: </font>
                </strong></h2>
        </div>
        <br>

        <div class="table-container">

        <table class="table caption-top" id="myTable">
            <thead>
                <tr align="center">
                    <th scope="col">Nombre</th>
                    <th scope="col">Raza</th>
                    <th scope="col">Fecha de Nacimiento</th>
                    <th scope="col">Perfil</th> 
                    
                </tr>
            </thead>
            <tbody>
                <?php

        



                while ($fila = mysqli_fetch_array($result)) {
                ?>
                    <tr align="center">
                        <td><?php echo $fila['nombre_mascota']; ?></td>
                        <td><?php echo $fila['raza']; ?></td>           
                        <td><?php echo $fila['fecha_nacimiento']; ?></td>
                        <td><a class="btn btn-primary" href="../mascotas/perfil.php?mascota_id=<?php echo $fila['mascota_id']?>" role="button">Perfil</a>
</td>
                        
                        
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
            </div>
        <!--Fin de Tabla-->

        <script>
            $(document).ready(function() {
                $('#myTable').DataTable({
                  
                    
                });
            });
        </script>


    </body>

</html>