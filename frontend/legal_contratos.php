<?php
#estamos fijando departamento id 1 para todos los documentos 
$_DEPARTAMENTO = 8;

require "../backend/conexion.php";

if (isset($_POST['subir_archivos'])) {

  $nombre = $_FILES['archivo']['name'];
  $guardado = $_FILES['archivo']['tmp_name'];

  if (!file_exists('archivos')) {
    mkdir('archivos', 0777, true);
    if (file_exists('archivos')) {
      if (move_uploaded_file($guardado, 'archivos/' . $nombre)) {
        echo "<script>alert('Archivo guardado con exito')</script>";
      } else {
        echo "<script>alert('Archivo no se pudo guardar')</script>";
      }
    }
  } else {
    if (move_uploaded_file($guardado, 'archivos/' . $nombre)) {
      echo "<script>alert('Archivo guardado con exito')</script>";
    } else {
      echo "<script>alert('Archivo no se pudo guardar')</script>";
    }
  }


  if (file_exists('archivos/' . $nombre)) {
    if (registrar_archivos_bd($nombre, 'archivos/' . $nombre, $_DEPARTAMENTO, $conexion)) {
      echo "<script>alert('Archivo Registrado')</script>";
    } else {
      echo "<script>alert('Archivo No Registrado')</script>";
    }
  }
}

if (isset($_POST['aprobar'])) {
  if (actualizarStatus_bd(1, $conexion, $_POST['ID_documento'])) {
    echo "<script>alert('Estatus actualizado')</script>";
  } else {
    echo "<script>alert('Estatus no actualizado')</script>";
  }
}

if (isset($_POST['rechazar'])) {
  if (actualizarStatus_bd(2, $conexion, $_POST['ID_documento'])) {
    echo "<script>alert('Estatus actualizado')</script>";
  } else {
    echo "<script>alert('Estatus no actualizado')</script>";
  }
}

$documentosPendientes = getDocumentosLegalesPendientes($conexion);
$documentosAceptados = getDocumentosLegalesAprobados($conexion);
$documentosRechazados = getDocumentosLegalesRechazados($conexion);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Legal - Contratos</title>

  <!-- stylesheets and bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/indexStyle.css">
  <link rel="stylesheet" href="../css/administración.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/sidebar.css">

</head>

<body class="sb-nav-fixed">

  <div id="mySidebar" class="sidebar">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <h1 style="color: white; font-size: 30px;">Legal</h1>
    <a href="../frontend/index.php">Inicio</a>
    <a href="../frontend/legal_index.php">Volver</a>
  </div>

  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark mb-0">
    <!-- Sidebar Toggle-->
    <button class="openbtn" onclick="openNav()">&#9776;</button>
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="legal_contratos.php">Legal</a>
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

  <div class="row">
    <div class="col-md-12 contenedorInferior">
      <form action="legal_contratos.php" method="POST" enctype="multipart/form-data">
        <h1 class="titulosAdmin">Subir peticiones de legal</h1>
        <center>
          <h1> </h1>
          <div class="">
            <input type="file" class="btn" name="archivo" value="Seleccionar">
          </div>
        </center>



        <p class="center">
          <center>
            <input type="submit" class="btn button-" name="subir_archivos" value="subir archivo">
          </center>
        </p>
      </form>
    </div>
  </div>

  <?php
  if (mysqli_num_rows($documentosPendientes) > 0) {
  ?>

    <div class="container-fluid main p-5">
      <h1 class="titulosAdmin">Pendientes</h1>
      <div class="d-flex justify-content-around">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div id="Carousel" class="carousel slide">
                <ol class="carousel-indicators">
                  <?php
                  for ($slide = 0; $slide < getNumSlidesFromDocuments(mysqli_num_rows($documentosPendientes)); $slide++) {
                  ?>
                    <li data-target="#Carousel" data-slide-to="<?php echo $slide;  ?>" <?php if ($slide == 0) {
                                                                                          echo "class='active'";
                                                                                        } ?>></li>
                  <?php } ?>
                </ol>
                <br><br>
                <!-- Carousel items -->

                <div class="carousel-inner">
                  <?php
                  $currentIndex = array();
                  for ($slide = 0; $slide < getNumSlidesFromDocuments(mysqli_num_rows($documentosPendientes)); $slide++) {
                    $stepCounter = 0;
                  ?>

                    <div class="item<?php if ($slide == 0) {
                                      echo ' active';
                                    } ?>">
                      <div class="row">
                        <?php
                        while ($row = mysqli_fetch_assoc($documentosPendientes)) {
                          if (!in_array($row["ID_documento"], $currentIndex) && $stepCounter < 3) {
                            #echo "id: " . $row["ID_documento"]. " - Name: " . $row["Nombre"]. " " . $row["Directorio"]." ". $row["ID_departamento"]." ". $row["Estado"]. "<br>";
                        ?>
                            <div class="col-md-4">
                              <embed src="<?php echo $row['Directorio']; ?>" type="application/pdf" width="220px" height="300px">
                              &nbsp;&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;<a href="<?php echo $row['Directorio']; ?>"><button class="btn button-">Abrir</button></a><br><br>

                              &nbsp;&nbsp;&emsp;<form action="legal_contratos.php" method="POST">
                                <input type="text" hidden value="<?php echo $row['ID_documento']; ?>" name="ID_documento">
                                <input class="btn button-" type="submit" name="aprobar" value="Aceptar">
                                <input class="btn button-" type="submit" name="rechazar" value="Rechazar">
                              </form>
                            </div>
                        <?php
                            array_push($currentIndex, $row["ID_documento"]);
                            $stepCounter++;
                          }
                        }
                        ?>
                      </div>
                      <!--.item-->
                    </div>
                    <!--.item-->

                  <?php } ?>
                </div>
              </div>
              <a data-slide="prev" href="#Carousel" class="botonIzquierdo">‹</a>
              <a data-slide="next" href="#Carousel" class="botonDerecho">›</a>
              <br><br><br>
            </div>


          </div>
        </div>
      </div>
    </div>

  <?php
  } else {
  ?>
    <div class="container-fluid main p-5">
      <h1 class="titulosAdmin">Pendientes</h1>
      <label>
        No se encontraton documentos con estatus pendientes
      </label>
    </div>

  <?php
  }
  ?>


  <!-- aceptados -->

  <?php
  if (mysqli_num_rows($documentosAceptados) > 0) {
  ?>

    <div class="container-fluid main p-5">
      <h1 class="titulosAdmin">Aceptados</h1>
      <div class="d-flex justify-content-around">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div id="Carousel2" class="carousel slide">
                <ol class="carousel-indicators">
                  <?php
                  for ($slide2 = 0; $slide2 < getNumSlidesFromDocuments(mysqli_num_rows($documentosAceptados)); $slide2++) {
                  ?>
                    <li data-target="#Carouse2" data-slide-to="<?php echo $slide2;  ?>" <?php if ($slide2 == 0) {
                      echo "class='active'";
                      } ?>></li>
                  <?php } ?>
                </ol>
                <br><br>
                <!-- Carousel items -->

                <div class="carousel-inner">
                  <?php
                  $currentIndex2 = array();
                  for ($slide2 = 0; $slide2 < getNumSlidesFromDocuments(mysqli_num_rows($documentosAceptados)); $slide2++) {
                    $stepCounter2 = 0;
                  ?>

                    <div class="item<?php if ($slide2 == 0) {
                                      echo ' active';
                                    } ?>">
                      <div class="row">
                        <?php
                        while ($row2 = mysqli_fetch_assoc($documentosAceptados)) {
                          if (!in_array($row2["ID_documento"], $currentIndex2) && $stepCounter2 < 3) {
                            #echo "id: " . $row["ID_documento"]. " - Name: " . $row["Nombre"]. " " . $row["Directorio"]." ". $row["ID_departamento"]." ". $row["Estado"]. "<br>";
                        ?>
                            <div class="col-md-4">
                              <embed src="<?php echo $row2['Directorio']; ?>" type="application/pdf" width="220px" height="300px">
                              &nbsp;&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;<a href="<?php echo $row2['Directorio']; ?>"><button class="btn button-">Abrir</button></a><br><br>

                              &nbsp;&nbsp;&emsp;<form action="legal_contratos.php" method="POST">
                                <input type="text" hidden value="<?php echo $row2['ID_documento']; ?>" name="ID_documento">
                                <input class="btn button-" type="submit" name="rechazar" value="Rechazar">
                              </form>
                            </div>
                        <?php
                            array_push($currentIndex2, $row2["ID_documento"]);
                            $stepCounter2++;
                          }
                        }
                        ?>
                      </div>
                      <!--.item-->
                    </div>
                    <!--.item-->

                  <?php } ?>
                </div>
              </div>
              <a data-slide="prev" href="#Carouse2" class="botonIzquierdo">‹</a>
              <a data-slide="next" href="#Carouse2" class="botonDerecho">›</a>
              <br><br><br>
            </div>


          </div>
        </div>
      </div>
    </div>

  <?php
  } else {
  ?>
    <div class="container-fluid main p-5">
      <h1 class="titulosAdmin">Aceptados</h1>
      <label>
        No se encontraton documentos con estatus aceptados
      </label>
    </div>

  <?php
  }
  ?>

  <!-- /aceptados -->


  <!-- rechazados -->

  <?php
  if (mysqli_num_rows($documentosRechazados) > 0) {
  ?>

    <div class="container-fluid main p-5">
      <h1 class="titulosAdmin">Rechazados</h1>
      <div class="d-flex justify-content-around">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div id="Carousel3" class="carousel slide">
                <ol class="carousel-indicators">
                  <?php
                  for ($slide3 = 0; $slide3 < getNumSlidesFromDocuments(mysqli_num_rows($documentosRechazados)); $slide3++) {
                  ?>
                    <li data-target="#Carouse3" data-slide-to="<?php echo $slide3;  ?>" <?php if ($slide3 == 0) {
                                                                                          echo "class='active'";
                                                                                        } ?>></li>
                  <?php } ?>
                </ol>
                <br><br>
                <!-- Carousel items -->

                <div class="carousel-inner">
                  <?php
                  $currentIndex3 = array();
                  for ($slide3 = 0; $slide3 < getNumSlidesFromDocuments(mysqli_num_rows($documentosRechazados)); $slide3++) {
                    $stepCounter3 = 0;
                  ?>

                    <div class="item<?php if ($slide3 == 0) {
                                      echo ' active';
                                    } ?>">
                      <div class="row">
                        <?php
                        while ($row3 = mysqli_fetch_assoc($documentosRechazados)) {
                          if (!in_array($row3["ID_documento"], $currentIndex3) && $stepCounter3 < 3) {
                            #echo "id: " . $row["ID_documento"]. " - Name: " . $row["Nombre"]. " " . $row["Directorio"]." ". $row["ID_departamento"]." ". $row["Estado"]. "<br>";
                        ?>
                            <div class="col-md-4">
                              <embed src="<?php echo $row3['Directorio']; ?>" type="application/pdf" width="220px" height="300px">
                              &nbsp;&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;<a href="<?php echo $row3['Directorio']; ?>"><button class="btn button-">Abrir</button></a><br><br>

                              &nbsp;&nbsp;&emsp;<form action="legal_contratos.php" method="POST">
                                <input type="text" hidden value="<?php echo $row3['ID_documento']; ?>" name="ID_documento">
                                <input class="btn button-" type="submit" name="aprobar" value="Aceptar">
                              </form>
                            </div>
                        <?php
                            array_push($currentIndex3, $row3["ID_documento"]);
                            $stepCounter3++;
                          }
                        }
                        ?>
                      </div>
                      <!--.item-->
                    </div>
                    <!--.item-->

                  <?php } ?>
                </div>
              </div>
              <a data-slide="prev" href="#Carouse3" class="botonIzquierdo">‹</a>
              <a data-slide="next" href="#Carouse3" class="botonDerecho">›</a>
              <br><br><br>
            </div>


          </div>
        </div>
      </div>
    </div>

  <?php
  } else {
  ?>
    <div class="container-fluid main p-5">
      <h1 class="titulosAdmin">Rechazados</h1>
      <label>
        No se encontraton documentos con estatus rechazados
      </label>
    </div>

  <?php
  }
  ?>

  <!-- /rechazados -->

  <!-- Scripts for bootstrap -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="../js/sidebar.js"></script>
</body>

</html>