<?php
    include_once("../../config.php");
    $pagSeleccionada = "Home";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once($ESTRUCTURA . "/header.php"); ?>
    <?php include_once($ESTRUCTURA . "/cabeceraBD.php"); ?>
</head>

<body>
    <!--  <div class="container text-center my-4">-->
    <div id="fondo">
        <div id="filtro-opacidad">
            <div id="contenido">
                <h2>Bienvenidos</h2>
            </div>
        </div>
    </div>
    <?php include_once($ESTRUCTURA . "/pie.php"); ?>
</body>

</html>