<?php
include_once("../../../configuracion.php");

/**************************************/
/********* PROGRAMA GENERAL ***********/
/**************************************/
$datos = data_submitted();
$objCompraEstado = new C_CompraEstado();
$arrayCompraEstado = $objCompraEstado->buscar($datos);
$idCompra["idCompra"] = $arrayCompraEstado[0]->getCompra()->getIdCompra();
$arrayObjProductoCarrito = obtenerProductos($idCompra);
if ($arrayObjProductoCarrito != null) {
    if (modificarEstadoCompra($datos, $arrayCompraEstado[0])) {
        foreach ($arrayObjProductoCarrito as $objProductoCarrito) {
            modificarStockProducto($objProductoCarrito);
        }
        echo json_encode(array('success' => 1));
    } else {
        echo json_encode(array('success' => 0));
    }
}else{
    echo json_encode(array('success' => 2));
}

/**************************************/
/**************** MODULOS *************/
/**************************************/

/* Devuelve todos los productos del idCompra */
function obtenerProductos($idCompra)
{
    $objCompraItem = new C_CompraItem;
    $arrayCompraItem = $objCompraItem->buscar($idCompra);
    return $arrayCompraItem;
}

/* Modifica el estado de la compra a "iniciada" */
function modificarEstadoCompra($datos, $compraEstado){
    $objCompraEstado = new C_CompraEstado();
    $resp = false;
    $paramCompraEstado = null;
    $fecha = new DateTime();
    $fechaStamp = $fecha->format('Y-m-d H:i:s');
    $paramCompraEstado = [
        "idCompraEstado" => $datos["idCompraEstado"],
        "idCompra" => $compraEstado->getCompra()->getIdCompra(),
        "idCompraEstadoTipo" => 2,
        "ceFechaIni" => $fechaStamp,
        "ceFechaFin" => null,
    ];
    if($objCompraEstado->modificacion($paramCompraEstado)){
        $resp = true;
    }
    return $resp;
}

/* Modifica el es stock del producto */
function modificarStockProducto($objProductoCarrito)
{
    $objProducto = new C_Producto();
    $idProducto["idProducto"] = $objProductoCarrito->getObjProducto()->getIdProducto();
    $arrayProducto = $objProducto->buscar($idProducto);
    $resp = false;
    $stockTot = $arrayProducto[0]->getCantStock() - $objProductoCarrito->getCantidad();
    $paramProducto = [
        "idProducto" => $arrayProducto[0]->getIdProducto(),
        "proNombre" => $arrayProducto[0]->getNombre(),
        "proDetalle" => $arrayProducto[0]->getDetalle(),
        "proPrecio" => $arrayProducto[0]->getProPrecio(),
        "urlImagen" => $arrayProducto[0]->getUrlImagen(),
        "proCantStock" => $stockTot
    ];
    if ($objProducto->modificacion($paramProducto)) {
        $resp = true;
    }
    return $resp;
}
