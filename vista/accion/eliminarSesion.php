<?php
    include_once("../../config.php");
    $pagSeleccionada = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once($ESTRUCTURA."/header.php"); ?>
    <?php include_once($ESTRUCTURA."/cabeceraBD.php"); ?>
</head>
<body>
    <?php
        $exito = $objSession -> cerrar();
        if ($exito)
        {
            echo '
            <div class="bg-success-subtle">
                <h3 class="text-success fs-5 text-center p-3">Sesion cerrada, redirigiendo</h3>
            </div>';
            header("Refresh: 1; URL='$VISTA/acceso/login.php'");
        }
        else
        {
            echo '
            <div class="bg-danger">
                <h3 class="fs-5 text-center p-3">Error, la sesion no se pudo cerrar, redirigiendo</h3>
            </div>';
            header("Refresh: 1; URL='$VISTA/pagSegura/pagSegura.php'");
        }
        include_once($ESTRUCTURA."/pie.php"); 
    ?>
</body>
</html>