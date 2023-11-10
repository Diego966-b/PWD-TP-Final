<?php
    include_once("../../config.php");
    $pagSeleccionada = "Productos";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once($ESTRUCTURA."/header.php"); ?>
    <?php include_once($ESTRUCTURA."/cabeceraBD.php"); ?>
</head>
<body>
    <?php
        if ($objSession -> validar())
        {
            $tienePermiso = $objSession -> tienePermisoB($objSession->getUsuario());
            if (!$tienePermiso)
            {
                header("Refresh: 3; URL='$VISTA/acceso/login.php'");
            }
        }
        else
        {
            header("Refresh: 3; URL='$VISTA/acceso/login.php'");
        }
    ?>
    <!-- Lista de prodcutos a la venta -->
    <h1>productos</h1>
    <?php include_once($ESTRUCTURA."/pie.php"); ?>
</body>
</html>