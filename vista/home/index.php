<?php
    include_once("../../config.php");
    $pagSeleccionada = "Home";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once($ESTRUCTURA."/header.php"); ?>
    <?php include_once($ESTRUCTURA."/cabeceraBD.php"); ?>
    <h2>Home</h2>
</head>
<body>
    <div class="container text-center my-4">
        <img src='<?php echo $VISTA;?>/imagenes/almacen.jpeg' class="img-fluid mx-auto" alt="Almacen">
    </div>
    <?php include_once($ESTRUCTURA."/pie.php"); ?>
</body>
</html>