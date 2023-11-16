<?php
    include_once("../../../config.php");
    include_once($ESTRUCTURA."/header.php");
    include_once($ESTRUCTURA."/cabeceraBD.php");
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $colDatos = data_submitted();
    $objSession -> pagarCarrito($colDatos);

?>