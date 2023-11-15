<?php
    include_once("../../../config.php");
    include_once($ESTRUCTURA."/header.php");
    include_once($ESTRUCTURA."/cabeceraBD.php");
    $colDatos = data_submitted();
    $arrayProducto = [];
    $arrayProducto ["proImagen"] = $colDatos ["proImagen"];
    $arrayProducto ["proPrecio"] = $colDatos["proPrecio"];
    $arrayProducto ["proDetalle"] = $colDatos["proDetalle"];
    $arrayProducto ["proNombre"] = $colDatos["proNombre"];
    $arrayProducto ["proCantStock"] = $colDatos["proCantStock"];
    $arrayProducto ["idProducto"] = $colDatos['idProducto'];
    $arrayProducto ["proCantidad"] = $colDatos["proCantidad"];

    $objSession -> agregarItemCarrito($arrayProducto);
?>
