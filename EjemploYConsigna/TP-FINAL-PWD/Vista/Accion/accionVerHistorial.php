<?php
include_once("../../configuracion.php");

$datos = data_submitted();
$objCompraEstado = new C_CompraEstado();
$arrayCompraEstado = $objCompraEstado->buscar($datos);
if ($arrayCompraEstado != null) {
    $arrayJS = arrayArmadoJS($arrayCompraEstado);
    echo json_encode(array('success' => $arrayJS));
} else {
    echo json_encode(array('success' => 0));
}


/* Arma un array para que se pueda ver en JS */
function arrayArmadoJS($arrayCompraEstado){
    $arrayJS = [];
    foreach($arrayCompraEstado as $compraEstado){
        $param = [
            "idCompra" => $compraEstado->getIdCompraEstado(),
            "NombreUsuario" => $compraEstado->getCompra()->getObjUsuario()->getUsNombre(),
            "Estado" => $compraEstado->getCompraEstadoTipo()->getCetDescripcion(),
            "FechaInicio" => $compraEstado->getCeFechaIni(),
            "FechaFin" => $compraEstado->getCeFechaFin(),
        ];
        array_push($arrayJS, $param);
    }
    return $arrayJS;
}