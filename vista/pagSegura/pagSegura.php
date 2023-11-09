<?php
    include_once("../../config.php");
    $pagSeleccionada = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once($ESTRUCTURA."/header.php"); ?>
    <?php include_once($ESTRUCTURA."/cabeceraBD.php"); 
    if ($objSession->validar())
    {
        $tienePermiso = $objSession -> tienePermiso (2); // Id del rol dependiendo de la pag. 
        echo $tienePermiso;
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
</head>
<body>
    <h2>VISTA SEGURA!</h2>
    <?php include_once($ESTRUCTURA."/pie.php"); ?>
</body>
</html>