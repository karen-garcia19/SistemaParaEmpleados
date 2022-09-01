<?php

include '../backend/conexion.php';

function console_log($output, $with_script_tags = true)
{
  $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
    ');';
  if ($with_script_tags) {
    $js_code = '<script>' . $js_code . '</script>';
  }
  echo $js_code;
}

if (isset($_POST["submit"])) {
  $id_empleado = $_POST["id_empleado"];
  $nombre = $_POST["nombre"];
  $apellido = $_POST["apellido"];
  $correo = $_POST["correo"];
  $usuario = $_POST["usuario"];
  $id_departamento = $_POST["departamento"];
  $contrasena = $_POST["password"];
  $query = "INSERT INTO empleados (ID_empleado,ID_departamento,Nombre_empleado,Apellido_empleado,Correo,Usuario,pass) VALUES ($id_empleado,$id_departamento,'$nombre','$apellido','$correo','$usuario',$contrasena)";
  if (mysqli_query($conexion, $query)) {
    #echo "Registro exitoso";
  } else {
    echo "Error: " . $query . "<br>" . mysqli_error($conexion);
  }
}

if (isset($_POST['submit2'])) {
  $id_empleado = $_POST["id_empleado"];
  $nombre = $_POST["nombre"];
  $apellido = $_POST["apellido"];
  $correo = $_POST["correo"];
  $usuario = $_POST["usuario"];
  $id_departamento = $_POST["departamento"];
  $contrasena = $_POST["password"];
  $query = "UPDATE empleados SET Nombre_empleado = '$nombre', Apellido_empleado = '$apellido', Correo = '$correo', Usuario = '$usuario', pass = '$contrasena', ID_departamento = '$id_departamento' WHERE ID_empleado = '$id_empleado'";
  if (mysqli_query($conexion, $query)) {
    #echo "Modificacion exitosa";
  } else {
    echo "Error: " . $query . "<br>" . mysqli_error($conexion);
  }
}

if (isset($_POST['submit3'])) {
  $id_empleado = $_POST["id_empleado"];
  $query = "DELETE FROM empleados WHERE ID_empleado = '$id_empleado'";
  if (mysqli_query($conexion, $query)) {
    #echo "Eliminacion exitosa";
  } else {
    echo "Error: " . $query . "<br>" . mysqli_error($conexion);
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>RRHH - Proveedores</title>

  <!-- stylesheets and bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/stylemenurecursos.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/sidebar.css">

</head>

<body>

  <div id="mySidebar" class="sidebar">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="../frontend/index.php">Inicio</a>
    <a href="../frontend/rrhh_index.php">Volver</a>

  </div>

  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark mb-0">
    <!-- Sidebar Toggle-->
    <button class="openbtn" onclick="openNav()">&#9776;</button>
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="#">Recursos Humanos</a>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
      <div class="input-group">
        <!--<input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />-->
        <!--<button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>-->
      </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
      <li class="nav-item dropdown">
        <?php

        session_start();
        if (!isset($_SESSION['u'])) {
          echo "<a class='nav-link dropdown-toggle' href='#' id='navbarDropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
              <i class='fas fa-user fa-fw'></i>Usuario</a>";
          echo "<div class='dropdown-menu dropdown-menu-right' aria-labelledby='navbarDropdownMenuLink'>";
          echo "<a class='dropdown-item' href='./login.php'>Iniciar sesión</a>";
          echo "</div>";
        } else {
          echo "<a class='nav-link dropdown-toggle' href='#' id='navbarDropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
              <i class='fas fa-user fa-fw'></i>" . $_SESSION['u'] . "</a>";
          echo "<div class='dropdown-menu dropdown-menu-right' aria-labelledby='navbarDropdownMenuLink'>";
          echo "<a class='dropdown-item' href='../backend/cerrar_sesion.php'>Cerrar sesión</a>";
          echo "</div>";
        }

        ?>
      </li>
    </ul>
  </nav>

  <div class="contenedorInferior">
    <div id="main" class="container-fluid p-5">
      <div class="row">
        <div class="col-9">
          <!-- /.card-header -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Empleado</h3>
            </div>
            <div class="card-body">
              <table id="inventario-table" class="table table-bordered table-hover">
                <tr>
                  <td>ID Empleado</td>
                  <td>Nombre</td>
                  <td>Apellido</td>
                  <td>Correo</td>
                  <td>Usuario</td>
                  <td>Id_Departamento</td>
                </tr>
                <?php
                $sql = "select ID_empleado, Nombre_empleado, Apellido_empleado,
                Correo, Usuario, ID_departamento from empleados";
                $result = mysqli_query($conexion, $sql);
                while ($mostrar = mysqli_fetch_array($result)) {
                ?>
                  <tr>
                    <td><?php echo $mostrar['ID_empleado'] ?></td>
                    <td><?php echo $mostrar['Nombre_empleado'] ?></td>
                    <td><?php echo $mostrar['Apellido_empleado'] ?></td>
                    <td><?php echo $mostrar['Correo'] ?></td>
                    <td><?php echo $mostrar['Usuario'] ?></td>
                    <td><?php echo $mostrar['ID_departamento'] ?></td>
                  </tr>
                <?php
                }
                ?>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="col d-flex flex-column p-5">
        <button class="btn mb-5 button-" data-toggle="modal" name="add" data-target="#adModal">Añadir</button>
        <button class="btn mb-5 button-" data-toggle="modal" data-target="#modModal">Modificar</button>
        <button class="btn mb-5 button-" data-toggle="modal" data-target="#delModal">Eliminar</button>
      </div>
    </div>
  </div>

  <div class="modal fade" id="adModal" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Añadir Empleado</h4>
        </div>
        <div class="modal-body">
          <form method="post">
            <div class="form-group">
              <label for="select-id_empleado">ID_empleado</label>
              <input type="number" id="id_empleado" name="id_empleado" class="form-control" maxlenght="9999999999" minlength="0" placeholder="ID_empleado" required="">
              <label for="select-nombre">Nombre</label>
              <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" required="">
              <label for="select-apellido">Apellido</label>
              <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Apellido" required="">
              <label for="select-correo">Correo</label>
              <input type="text" id="correo" name="correo" class="form-control" placeholder="Correo" required="">
              <label for="select-usuario">Usuario</label>
              <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Usuario" required="">
              <label for="select-departamento">Departamento</label>
              <input type="number" id="departamento" name="departamento" class="form-control" placeholder="Departamento" required="">
              <label for="password">Contraseña</label>
              <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required="">
            </div>
            <button type="submit" value="submit" name="submit" class="btn btn-default">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="delModal" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Eliminar Empleado</h4>
        </div>
        <div class="modal-body">
          <form method="post">
            <div class="form-group">
              <label for="select-id_empleado">ID_empleado</label>
              <input type="number" id="id_empleado" name="id_empleado" class="form-control" maxlenght="9999999999" minlength="0" placeholder="ID_empleado" required="">
            </div>
            <button type="submit" value="submit2" name="submit3" class="btn btn-default">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modModal" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Empleado</h4>
        </div>
        <div class="modal-body">
          <form method="post">
            <div class="form-group">
              <label for="select-id_empleado">ID_empleado</label>
              <input type="number" id="id_empleado" name="id_empleado" class="form-control" maxlenght="9999999999" minlength="0" placeholder="ID_empleado" required="">
              <label for="select-nombre">Nombre</label>
              <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" required="">
              <label for="select-apellido">Apellido</label>
              <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Apellido" required="">
              <label for="select-correo">Correo</label>
              <input type="text" id="correo" name="correo" class="form-control" placeholder="Correo" required="">
              <label for="select-usuario">Usuario</label>
              <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Usuario" required="">
              <label for="select-departamento">Departamento</label>
              <input type="number" id="departamento" name="departamento" class="form-control" placeholder="Departamento" required="">
              <label for="password">Contraseña</label>
              <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required="">
            </div>
            <button type="submit" value="submit2" name="submit2" class="btn btn-default">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts for bootstrap -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
<script>
  $(document).ready(function() {
    $('#inventario-table').DataTable({
      "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
      ]
    });
  });
</script>
<script src="../js/sidebar.js"></script>

</html>