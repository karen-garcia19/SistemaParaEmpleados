<?php
// * conexion a la base de datos

$bd = 'upv_red';
$servidor = 'localhost';
$usuario = 'ghost'; //$usuario
$contrasena = '123'; //$contrasena

// * Creamos la conexion a la base de datos
$conexion = mysqli_connect($servidor, $usuario, $contrasena, $bd);

// * Checamos la conexion
if (!$conexion) {
    die('Conexión a la base de datos ' . $bd . ' fallida: ' .
        mysqli_connect_error());
}

function valida_usuario_bd($usuario, $contrasena, $conexion)
{
    $query = "SELECT * FROM empleados WHERE Usuario = '$usuario' AND pass = '$contrasena'";
    //echo $query;
    $resultado = mysqli_query($conexion, $query) or die(mysqli_error($conexion));
    $filas = mysqli_num_rows($resultado);
    if (mysqli_num_rows($resultado) == 0) {
        return false;
        echo "Usuario o contraseña incorrectos";
    } else {
        return true;
    }
};

function registrar_usuario_bd($nombre, $apellido, $correo, $usuario, $password, $departamento, $conexion)
{
    echo "nombre: " . $nombre . " apellido: " . $apellido . " correo: " . $correo . " usuario: " . $usuario . " password: " . $password . " departamento " . $departamento;
    $query = "INSERT INTO empleados (ID_empleado,ID_departamento,Nombre_empleado,Apellido_empleado,Correo,Usuario,pass) 
    VALUES (DEFAULT,$departamento,'$nombre','$apellido','$correo','$usuario','$password')";
    if (mysqli_query($conexion, $query)) {
        echo "Registro exitoso";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conexion);
    }
}

function modificar_empleado($nombre, $apellido, $correo, $usuario, $password, $departamento, $conexion, $id)
{
    $query = "UPDATE empleados SET Nombre_empleado = '$nombre',
     Apellido_empleado = '$apellido', Correo = '$correo',
      Usuario = '$usuario', pass = '$password', ID_departamento = '$departamento'
       WHERE ID_empleado = '$id'";
    if (mysqli_query($conexion, $query)) {
        echo "Modificacion exitosa";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conexion);
    }
}

function borrar_empleados($conexion, $usuario)
{
    echo "Borrar empleados";
    $query = "DELETE FROM empleados WHERE usuario = '$usuario'";
    if (mysqli_query($conexion, $query)) {
        echo "borrado exitoso";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conexion);
    }
}

function registrar_citas($nombre, $telefono, $descripcion, $fecha, $conexion)
{
    $query = "INSERT INTO citas (ID_cita,Nombre_cliente,Telefono,Descripcion,Fechas) 
    VALUES (DEFAULT,'$nombre',$telefono,'$descripcion','$fecha')";
    if (mysqli_query($conexion, $query)) {
        echo "Registro exitoso";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conexion);
    }
}

function borrar_citas($id, $conexion)
{
    $query = "DELETE FROM citas WHERE id_cita = $id";
    if (mysqli_query($conexion, $query)) {
        echo "Borrado exitoso exitoso";
    } else {
        echo "Error: " . $query . "br" . mysqli_error($conexion);
    }
}

function registrar_archivos_bd($nombre, $guardado, $dep, $conexion)
{
    $query = "INSERT INTO documento (Nombre, Directorio, ID_departamento, Estado) VALUES ('$nombre', '$guardado', " . $dep . ", 0);";
    $resultado = mysqli_query($conexion, $query);
    return $resultado;
}

function actualizarStatus_bd($estado, $conexion, $id_doc)
{
    $query = "UPDATE documento SET Estado='$estado' WHERE ID_documento='$id_doc'";
    $resultado = mysqli_query($conexion, $query);
    return $resultado;
}

function getDocumentosLegalesPendientes($conexion)
{
    $query = "SELECT * FROM `documento` WHERE Estado = 0 and ID_departamento = (select ID_departamento FROM departamentos where Nombre_departamento = 'legal')";
    $resultado = mysqli_query($conexion, $query) or die(mysqli_error($conexion));
    return $resultado;
}

function getDocumentosLegalesAprobados($conexion)
{
    $query = "SELECT * FROM `documento` WHERE Estado = 1 and ID_departamento = (select ID_departamento FROM departamentos where Nombre_departamento = 'legal')";
    $resultado = mysqli_query($conexion, $query) or die(mysqli_error($conexion));
    return $resultado;
}

function getDocumentosLegalesRechazados($conexion)
{
    $query = "SELECT * FROM `documento` WHERE Estado = 2 and ID_departamento = (select ID_departamento FROM departamentos where Nombre_departamento = 'legal')";
    $resultado = mysqli_query($conexion, $query) or die(mysqli_error($conexion));
    return $resultado;
}

function getNumSlidesFromDocuments($documentosLength)
{
    $division = floor($documentosLength / 3);
    $resultado = $documentosLength % 3 == 0 ? $division : $division + 1;
    return $resultado;
}

function modificarempleados($id_empleado, $nombre_empleado, $apellido_empleado, $correo, $usuario, $id_departamento, $password, $conexion)
{
    $query = "UPDATE empleados SET Nombre_empleado = '$nombre_empleado', Apellido_empleado = '$apellido_empleado', Correo = '$correo', Usuario = '$usuario', ID_departamento = '$id_departamento', pass = '$password' WHERE ID_empleado = '$id_empleado'";
    if (mysqli_query($conexion, $query)) {
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conexion);
    }
}

function eliminarempleados($id_empleado, $conexion)
{
    $query = "DELETE FROM empleados WHERE ID_empleado = $id_empleado";
    if (mysqli_query($conexion, $query)) {
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conexion);
    }
}
