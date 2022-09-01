<?php

session_start(); //* Inicia o continua la session
if (!isset($_SESSION['u'])) {
    #header('Location: '); //* Redirigir al login
    #redirigir al login
    echo "No has iniciado sesion";
    header('Location: ../frontend/login.php'); //* Redirigir al login
    exit;
}