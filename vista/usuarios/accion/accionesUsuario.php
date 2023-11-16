<?php
include_once "../../../config.php";
$data = data_submitted();
$objUsuario = new AbmUsuario();
$objAbmCompra = new AbmCompra();
$objAbmCompraEstado = new AbmCompraEstado();
$objAmbCompraItem = new AbmCompraItem();
$respuesta = $objUsuario->abm($data);

if($data["accion"]== "editar"){
    $data["accion"]="actualizarRol";
    $respuesta=$objUsuario->abm($data);
}


if($data["accion"] == "bajaCompra"){
    $idCompra = $data['idCompra'];
    $listarCompraEstado = $objAbmCompraEstado->buscar(null);
    foreach($listarCompraEstado as $compraEstado){
        $idCompraActual = $compraEstado->getObjCompra()->getIdCompra();
        if($idCompra == $idCompraActual){
            $arrayBorrar = [];
            $arrayBorrar['idCompraEstado'] = $compraEstado->getIdCompraEstado();
            $arrayBorrar['accion'] = "borrar";
            $objAbmCompraEstado->abm($arrayBorrar);
        }
    }

    $listaObjCompraItem = $objAmbCompraItem->buscar(null);

    foreach ($listaObjCompraItem as $objCompraItem){
        $idCompraActual = $objCompraItem->getObjCompra()->getIdCompra();
        if($idCompra == $idCompraActual){
            $arrayBorrar2['idCompraItem'] = $objCompraItem->getIdCompraItem();
            $arrayBorrar2['accion'] = "borrar";
            $objAmbCompraItem->abm($arrayBorrar2);            
        }
    }

    $arregloCompras = $objAbmCompra->buscar($data);
    $objCompra = $arregloCompras[0];
    $array['idCompra'] = $objCompra->getIdCompra();
    $array['accion'] = "borrar";
    $respuesta=$objAbmCompra->abm($array);
}
if($respuesta){
    echo json_encode(array("success" => true));
}else{
    echo "no anduvo";
}

?>