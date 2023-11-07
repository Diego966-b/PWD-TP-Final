<?php
    include_once("../../config.php");
    $pagSeleccionada = "vistaPublica";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once($ESTRUCTURA."/header.php"); 
    $rol = "cliente";
    include($ESTRUCTURA."/cabecera.php");
    $rol = "noSeguro";
    include($ESTRUCTURA."/cabecera.php");
    $rol = "deposito";
    include($ESTRUCTURA."/cabecera.php");
    $rol = "admin";
    include($ESTRUCTURA."/cabecera.php");
    ?>
</head>
<body>
    <?php include_once($ESTRUCTURA."/pie.php"); ?>
</body>
</html>