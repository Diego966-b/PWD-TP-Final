<?php
include_once("../../../configuracion.php");

$datos = data_submitted();
$objCompraItem = new C_CompraItem();
$arrayCompraItem = $objCompraItem->buscar($datos);
if ($arrayCompraItem[0]->getCantidad() == $datos["ciCantidad"]){
    if ($objCompraItem->baja($datos)) {
        echo json_encode(array('success' => 1));
    } else {
        echo json_encode(array('success' => 0));
    }
}else{
    $cantStockTot = $arrayCompraItem[0]->getCantidad() - $datos["ciCantidad"];
    $datos["ciCantidad"] = $cantStockTot;
    $datos["idProducto"] = $arrayCompraItem[0]->getObjProducto()->getIdProducto();
    $datos["idCompra"] = $arrayCompraItem[0]->getObjCompra()->getIdCompra();
    if($objCompraItem->modificacion($datos)){
        echo json_encode(array('success' => 1));
    } else {
        echo json_encode(array('success' => 0));
    }
}
