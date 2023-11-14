<?php
    include_once("../../../config.php");
    include_once($ESTRUCTURA."/header.php");
    include_once($ESTRUCTURA."/cabeceraBD.php");
    $colDatos = data_submitted();
    $arrayConsulta = [];
    $idProducto = $colDatos ["idProducto"];
    $cantUnidades = $colDatos ["cantProductos"];

    $abmProducto = new AbmProducto();
    $arrayConsulta ["idProducto"] = $idProducto;
    $listaProductos = $abmProducto -> buscar($arrayConsulta);
    $objProducto = $listaProductos [0];
    $arrayProducto = convert_array($objProducto);
    $arrayProducto ["accion"] = "editar";
    $arrayProducto ["proCantStock"] = $arrayProducto["proCantStock"] + 1;
    $resultado = $abmProducto -> abm($arrayProducto);

    if ($arrayProducto["proCantStock"] == 0)
    {

    }
    $arrayCarrito = $_SESSION["carrito"];
    
?>
