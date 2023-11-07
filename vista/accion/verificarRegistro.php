<?php
    include_once("../../config.php");
    $pagSeleccionada = "login";
    $rol = "noSeguro";
    $colDatos = devolverDatos();
    $contraseniaIngresada = $colDatos ["usPass"];
    $nombreIngresado = $colDatos ["usNombre"];
?>