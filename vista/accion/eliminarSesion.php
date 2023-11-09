<?php
    include_once("../../config.php");
    $objSesion = new Session();
    $exito = $objSesion -> cerrar();
    if ($exito)
    {
        echo "Se cerro";
        header("Refresh: 2; URL='$VISTA/acceso/login.php'");
    }
    else
    {
        echo "No se cerro";
        header("Refresh: 2; URL='$VISTA/pagSegura/pagSegura.php'");
    }
?>