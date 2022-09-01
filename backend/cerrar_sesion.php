<?php

require 'abrir_session.php';
$_SESSION = array();
session_destroy();
header('Location: ../frontend/login.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerrar sesion</title>
</head>

<body>
    <p>

    <h1>Session Cerrada, hasta la proxima</h1>

    </p>
</body>

</html>