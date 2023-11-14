<?php
    include_once("../../../config.php");
    include_once($ESTRUCTURA."/header.php");
    include_once($ESTRUCTURA."/cabeceraBD.php");
    $colDatos = data_submitted();
    $abmProducto = new AbmProducto();
    $proStock = $colDatos["proCantStock"];
    $arrayConsulta = [];
    $arrayProducto = [];
    $entre = false;
    
    $idProducto = $colDatos['idProducto'];
    $proCantidadInicial = $colDatos['proCantidad'];

    $stockFinal = $proStock - $proCantidadInicial;
    if ($stockFinal >= 0)
    {
        $arrayConsulta ["proImagen"] = $colDatos ["proImagen"];
        $arrayConsulta ["proPrecio"] = $colDatos["proPrecio"];
        $arrayConsulta ["proDetalle"] = $colDatos["proDetalle"];
        $arrayConsulta ["proNombre"] = $colDatos["proNombre"];
        $arrayConsulta ["proCantStock"] = $stockFinal;
        $arrayConsulta ["idProducto"] = $idProducto;
        $arrayConsulta ["accion"] = "editar";


        $resultado = $abmProducto -> abm($arrayConsulta);
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = array();
        }

        $arrayCarrito = $_SESSION['carrito'];

        for ($i = 1; $i <= count($arrayCarrito); $i++)
        {
            $arrayProductoActual = [];
            $arrayProductoActual = $arrayCarrito [$i];
            $idProductoActual = $arrayProductoActual ["idProducto"];
            if ($idProductoActual == $idProducto)
            {
                $arrayCarrito[$i]["proCantidad"] += $proCantidadInicial;
                $idBuscado = $idProductoActual;
                $entre = true;
            }
        }
        $proCantidadFinal = $arrayCarrito[$i]["proCantidad"];
        if (!$entre)
        {
            $arrayProducto ["idProducto"] = $idProducto;
            $arrayProducto ["proCantidad"] = $proCantidadInicial;
            $arrayCarrito [$idProducto] = $arrayProducto;
        }
        $_SESSION['carrito'] = $arrayCarrito;
    }
?>
