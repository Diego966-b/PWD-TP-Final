<?php
    include_once("../../config.php");
    $pagSeleccionada = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once($ESTRUCTURA."/header.php"); ?>
    <?php include_once($ESTRUCTURA."/cabeceraBD.php"); 
        if ($objSession->validar()) {
            $tienePermiso = $objSession->tienePermisoB($objSession->getUsuario());
            if (!$tienePermiso) {
                header("Refresh: 3; URL='$VISTA/acceso/login.php'");
            }
            // agregar para todas las paginas 
            $estadoPagina = $objSession->estadoMenu();
            if (!$estadoPagina) {
                header("Refresh: 3; URL='$VISTA/home/index.php'");
            }
        } else {
            header("Refresh: 3; URL='$VISTA/acceso/login.php'");
        }
    ?>
</head>
<body>
    <h2>VISTA SEGURA!</h2>
    <?php include_once($ESTRUCTURA."/pie.php"); ?>
</body>
</html>