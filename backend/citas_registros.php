<?php

require "../conexion/conexion.php";
if (isset($_POST['aceptar'])) {
    $nombre = $_POST['nomb_cliente'];
    $telefono = $_POST['tel'];
    $descripcion = $_POST['desc'];
    $fecha = $_POST['fecha'];

    if (registrar_citas($nombre, $telefono, $descripcion, $fecha, $conexion)) {
        echo "Registro exitoso";
    }
}

if (isset($_POST['aceptar2'])) {

    $id = $_POST['number_id'];
    if (borrar_citas($id, $conexion)) {
        echo "borrado exitoso";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas General</title>
</head>

<body>

    <h1>Registrar Citas</h1>

    <form method="post">
        <input type="text" name="nomb_cliente" placeholder="Nombre" required="required" />
        <input type="text" name="tel" placeholder="Teléfono" required="required" />
        <textarea type="textarea" name="desc" placeholder="Descripción" required="required"></textarea>
        <input type="date" name="fecha" placeholder="Fecha" required="required" />
        <button name="aceptar" type="submit">Registrar Cita</button>
    </form>

    <h2>Eliminar Citas</h2>

    <form method="post">
        <input type="number" name="number_id" placeholder="ID de la cita" required="required" />
        <button name="aceptar2" type="submit">Eliminar</button>
    </form>


    <h1>Tabla de Citas</h1>
    <br>
    <table border="1">
        <tr>
            <td>ID Cita</td>
            <td>Nombre de Cliente</td>
            <td>Teléfono</td>
            <td>Descripcion</td>
            <td>Fecha</td>
        </tr>
        <?php
        $sql = "select id_cita, Nombre_cliente, Telefono, Descripcion, Fechas from citas";
        $result = mysqli_query($conexion, $sql);
        while ($mostrar = mysqli_fetch_array($result)) {
        ?>
        <tr>
            <td><?php echo $mostrar['id_cita'] ?></td>
            <td><?php echo $mostrar['Nombre_cliente'] ?></td>
            <td><?php echo $mostrar['Telefono'] ?></td>
            <td><?php echo $mostrar['Descripcion'] ?></td>
            <td><?php echo $mostrar['Fechas'] ?></td>
        </tr>
        <?php
        }
        ?>
    </table>
    <br />

</body>

</html>