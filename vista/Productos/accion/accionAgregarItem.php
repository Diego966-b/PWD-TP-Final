<?php
    include_once("../../../config.php");
    include_once($ESTRUCTURA."/header.php");
    include_once($ESTRUCTURA."/cabeceraBD.php");
    $colDatos = data_submitted();
    $arrayProducto = [];
<<<<<<< HEAD
    $arrayProducto ["proImagen"] = $colDatos ["proImagen"];
    $arrayProducto ["proPrecio"] = $colDatos["proPrecio"];
    $arrayProducto ["proDetalle"] = $colDatos["proDetalle"];
    $arrayProducto ["proNombre"] = $colDatos["proNombre"];
    $arrayProducto ["proCantStock"] = $colDatos["proCantStock"];
    $arrayProducto ["idProducto"] = $colDatos['idProducto'];
    $arrayProducto ["proCantidad"] = $colDatos["proCantidad"];

    $objSession -> agregarItemCarrito($arrayProducto);
=======
    $entre = false;
print_r($colDatos);
    $idProducto = $colDatos['idProducto'];
    $proCantidadInicial = $colDatos['proCantidad'];

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }

    $arrayCarrito = $_SESSION['carrito'];

    foreach ($arrayCarrito as $indice => $productoActual) {
        $idProductoActual = $productoActual["idProducto"];
    
        if ($idProductoActual == $idProducto) {
            // Si el producto ya está en el carrito, actualizo la cantidad
            $arrayCarrito[$indice]["proCantidad"] += $proCantidadInicial;
            $productoEncontrado = true;
            print_r($arrayCarrito);
            break; // Salgo del bucle ya que encontré el producto
        }
    }
    
    if (!$productoEncontrado) {
        // Si el producto no está en el carrito, lo agrego
        $arrayProducto = array(
            "idProducto" => $idProducto,
            "proCantidad" => $proCantidadInicial
        );
        array_push($arrayCarrito, $arrayProducto);
        print_r($arrayCarrito);
    }
    
    $_SESSION['carrito'] = $arrayCarrito;


    

>>>>>>> marco
?>
