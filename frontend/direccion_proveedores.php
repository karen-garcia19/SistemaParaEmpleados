<?php
require "../backend/conexion.php";

function console_log($output, $with_script_tags = true)
{
  $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
    ');';
  if ($with_script_tags) {
    $js_code = '<script>' . $js_code . '</script>';
  }
  echo $js_code;
}



if (isset($_POST["submit"])){
  $sql = "INSERT INTO proveedores (Id,Nombre_empresa,Producto)
        VALUES (DEFAULT,'" . $_POST['name'] . "','" . $_POST['product'] . "')";
  if (mysqli_query($conexion, $sql)) {
    //echo "New event added successfully";
  } else {
    //echo "Error: " . $sql . "<br>" . $conn->error;
  }
}



if (isset($_POST["mod"])){
  $id = $_POST['id'];
  $nombre = $_POST['name'];
  $product = $_POST['product'];
  $sql = "UPDATE proveedores SET Nombre_empresa =  '$nombre' ,  Producto = '$product'   WHERE Id = $id";
  if (mysqli_query($conexion, $sql)) {
    //echo "New event added successfully";
  } else {
    //echo "Error: " . $sql . "<br>" . $conn->error;
  }
}


if (isset($_POST["del"])){
  $id = $_POST['id'];
  $sql = "DELETE FROM proveedores WHERE Id = $id";
  if (mysqli_query($conexion, $sql)) {
    //echo "New event added successfully";
  } else {
    //echo "Error: " . $sql . "<br>" . $conn->error;
  }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Dirección - Proveedores</title>

  <!-- stylesheets and bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/indexStyle.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/sidebar.css">

</head>

<body>

  <div id="mySidebar" class="sidebar">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <h1 style="color: white; font-size: 30px;">Dirección General</h1>
    <a href="../frontend/index.php">Inicio</a>
    <a href="../frontend/direccion_index.php">Volver</a>
  </div>

  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark mb-0">
    <!-- Sidebar Toggle-->
    <button class="openbtn" onclick="openNav()">&#9776;</button>
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="produccion_index.php">Dirección General</a>
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


  <div id="main" class="container-fluid p-5">
    <div class="row">
      <div class="col-9">
        <!-- /.card-header -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Proveedores</h3>
          </div>
          <div class="card-body">
            <table id="inventario-table" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Nombre de la Empresa</th>
                  <th>Producto</th>
                </tr>
              </thead>
              <?php
                $sql = "SELECT Id,Nombre_empresa,Producto FROM proveedores";
                $result = mysqli_query($conexion, $sql);
                if(mysqli_num_rows($result) > 0){

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>'. $row['Id'] .'</td>';
                        echo '<td>'. $row['Nombre_empresa'] .'</td>';
                        echo '<td>'. $row['Producto'] .'</td>';
                        echo '</tr>';
                    }
                }
              ?>
              <tfoot>
                <tr>
                  <th>Id</th>
                  <th>Nombre de la Empresa</th>
                  <th>Producto</th>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <div class="col d-flex flex-column p-5">
        <button class="btn mb-5 button-" data-toggle="modal" name ="add" data-target="#adModal">Añadir</button>
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
              <h4 class="modal-title">Añadir provedor</h4>
          </div>
          <div class="modal-body">
              <form action="direccion_proveedores.php" method="post">
                <div class="form-group">
                  <label for="eventtitle">Nombre provedor:</label>
                  <input type="name" name="name" class="form-control" id="product" required="">
                  <label for="Telefono">Producto:</label>
                  <input type="product" name="product" class="form-control" id="product" require="">
                </div>
                  <button type="submit" value="submit" name="submit" class="btn btn-default">Submit</button>
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
              <h4 class="modal-title">Modificar provedor</h4>
          </div>
          <div class="modal-body">
              <form action="direccion_proveedores.php" method="post">
                <div class="form-group">
                  <label for="eventtitle">ID:</label>
                  <input type="number" name="id" class="form-control" id="id" required="">
                  <label for="eventtitle">Nombre provedor:</label>
                  <input type="name" name="name" class="form-control" id="name" required="">
                  <label for="Telefono">Producto:</label>
                  <input type="product" name="product" class="form-control" id="product" require="">
                </div>
                  <button type="submit" value="mod" name="mod" class="btn btn-default">Submit</button>
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
              <h4 class="modal-title">Borrar provedor</h4>
          </div>
          <div class="modal-body">
              <form action="direccion_proveedores.php" method="post">
                <div class="form-group">
                  <label for="eventtitle">ID:</label>
                  <input type="number" name="id" class="form-control" id="id" required="">
                </div>
                  <button type="submit" value="del" name="del" class="btn btn-default">Submit</button>
              </form>
          </div>
        </div>
    </div>
  </div>































  <!-- MODAL DE AÑADIR -->
  <div class="modal fade" id="modal-añadir">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Añadir</h4>
        </div>
        <div class="modal-body">
          <div class="form-group mb-3">
            <label for="select-nombre">Nombre del producto</label>
            <input type="text" id="nombre" class="form-control" placeholder="Nombre producto">
          </div>
          <div class="form-group mb-3">
            <label for="select-nombre">Cantidad de stock</label>
            <input type="number" id="stock" maxlenght="9999999999" minlength="0" class="form-control" placeholder="Cantidad en stock">
          </div>
          <div class="form-group mb-3">
            <label for="select-nombre">Descripcion</label>
            <input type="text" id="descripcion" class="form-control" placeholder="descripcion">
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn button-" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn button-">Añadir</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.MODAL DE AÑADIR  -->

  <!-- MODAL DE MODIFICAR -->
  <div class="modal fade" id="modal-modificar">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Modificar</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="select-nombre">Nombre del producto</label>
            <select id="select-nombre" class="form-control form-control-sm">
              <option>Desarmador</option>
            </select>
          </div>
          <div class="form-group mb-3">
            <label for="select-nombre">Cantidad de stock</label>
            <input type="number" id="stock" maxlenght="9999999999" minlength="0" class="form-control" placeholder="Cantidad en stock">
          </div>
          <div class="form-group mb-3">
            <label for="select-nombre">Descripcion</label>
            <input type="text" id="descripcion" class="form-control" placeholder="descripcion">
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn button-" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn button-">Aplicar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /. MODAL DE MODIFICAR -->

  <!-- MODAL DE MODIFICAR -->
  <div class="modal fade" id="modal-eliminar">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Eliminar</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="select-nombre">Nombre del producto</label>
            <select id="select-nombre" class="form-control form-control-sm">
              <option>Desarmador</option>
            </select>
          </div>
          <div class="form-group mb-3">
            <label for="select-nombre">Cantidad de stock</label>
            <input type="number" id="stock" maxlenght="9999999999" minlength="0" class="form-control" placeholder="Cantidad en stock">
          </div>
          <div class="form-group mb-3">
            <label for="select-nombre">Descripcion</label>
            <input type="text" id="descripcion" class="form-control" placeholder="descripcion">
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn button-" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn button-">Aplicar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /. MODAL DE MODIFICAR -->

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