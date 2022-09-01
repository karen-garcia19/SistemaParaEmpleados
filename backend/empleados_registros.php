<?php

require "../conexion/conexion.php";
if (isset($_POST['aceptar'])) {
    $nombre = $_POST['nomb'];
    $apellido = $_POST['ape'];
    $email = $_POST['email'];
    $password = $_POST['contrasena'];
    $departamento = $_POST['depa'];
    $usuario = $_POST['user'];

    if (registrar_usuario_bd($nombre, $apellido, $email, $usuario, $password, $departamento, $conexion)) {
        echo "Registro exitoso";
    }
}

if (isset($_POST['aceptar3'])) {
    $nombre = $_POST['nomb'];
    $apellido = $_POST['ape'];
    $email = $_POST['email'];
    $password = $_POST['contrasena'];
    $departamento = $_POST['depa'];
    $usuario = $_POST['user'];
    $id = $_POST['id'];

    if (modificar_empleado($nombre, $apellido, $email, $usuario, $password, $departamento, $conexion, $id)) {
        echo "Modificacion exitosa";
    }
};


if (isset($_POST['aceptar2'])) {

    $user = $_POST['usuario'];
    if (borrar_empleados($conexion, $user)) {
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
    <title>Registros</title>
</head>

<body>

    <h1> Crear empleados o insertar </h1>

    <form method="post">
        <input type="text" name="nomb" placeholder="Nombre" required="required" />
        <input type="text" name="ape" placeholder="Apellido" required="required" />
        <input type="text" name="email" placeholder="Email" required="required" />
        <input type="text" name="user" placeholder="Usuario" required="required" />
        <input type="password" name="contrasena" placeholder="Contraseña" required="required" />
        <input type="text" name="depa" placeholder="Departamento" required="required" />
        <button name="aceptar" type="submit">Registrar</button>
    </form>

    <h1>Modificar empleados</h1>
    <form method="post">
        <input type="text" name="nomb" placeholder="Nombre" required="required" />
        <input type="text" name="ape" placeholder="Apellido" required="required" />
        <input type="text" name="email" placeholder="Email" required="required" />
        <input type="text" name="user" placeholder="Usuario" required="required" />
        <input type="password" name="contrasena" placeholder="Contraseña" required="required" />
        <input type="text" name="depa" placeholder="Departamento" required="required" />
        <input type="number" name="id" placeholder="ID" required="required" />
        <button name="aceptar3" type="submit">Modificar</button>
    </form>

    <h1>Eliminar empleados o registros</h1>


    <form method="post">
        <input type="text" name="usuario" placeholder="Usuario" required="required">
        <button name="aceptar2" type="submit"> Aceptar</button>
    </form>

    <h1>Tabla de Usuarioss</h1>
    <br>
    <table border="1">
        <tr>
            <td>ID Empleado</td>
            <td>Nombre de Empleado</td>
            <td>Usuario</td>
        </tr>
        <?php
        $sql = "select ID_empleado, Nombre_empleado, Usuario from empleados";
        $result = mysqli_query($conexion, $sql);
        while ($mostrar = mysqli_fetch_array($result)) {
        ?>
        <tr>
            <td><?php echo $mostrar['ID_empleado'] ?></td>
            <td><?php echo $mostrar['Nombre_empleado'] ?></td>
            <td><?php echo $mostrar['Usuario'] ?></td>
        </tr>
        <?php
        }
        ?>
    </table>
    <br />

    <!-- Falta modificar usuarios -->

</body>

</html>