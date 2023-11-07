<?php
include_once("../../configuracion.php");

$datos = data_submitted();
$objCompraItem = new C_CompraItem();
$arrayCompraItem = $objCompraItem->buscar($datos);
if ($arrayCompraItem != null) {
    $arrayJS = arrayArmadoJS($arrayCompraItem);
    echo json_encode(array('success' => $arrayJS));
} else {
    echo json_encode(array('success' => 0));
}


/* Arma un array para que se pueda ver en JS */
function arrayArmadoJS($arrayCompraItem){
    $arrayJS = [];
    foreach($arrayCompraItem as $compraItem){
        $param = [
            "Nombre" => $compraItem->getObjProducto()->getNombre() ,
            "Descripcion" => $compraItem->getObjProducto()->getDetalle() ,
            "Precio" => $compraItem->getObjProducto()->getProPrecio() ,
            "Cantidad" => $compraItem->getCantidad(),
            "UrlImagen" => $compraItem->getObjProducto()->getUrlImagen(),
        ];
        array_push($arrayJS, $param);
    }
    return $arrayJS;
}