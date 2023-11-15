<?php
include_once('../../config.php');
$data = data_submitted();

$idCompra = $data['idCompra'];
$idCompraEstadoTipo = $data['idCompraEstadoTipo'];
$compraEstado = new AbmCompraEstado();

$arrObjCompraEstado = $compraEstado->buscar(null);
$arrObjCompraEstado = $arrObjCompraEstado[0];
$idCompraEstado = $arrObjCompraEstado->getIdCompraEstado();
// = $arrObjCompraEstado->getObjCompra()->getIdCompra();
$ceFechaIni = $arrObjCompraEstado->getCeFechaIni();
$ceFechaFin = $arrObjCompraEstado->getCeFechaFin();

date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha_actual = date("Y-m-d H:i:s");

$datos['idCompraEstado'] = $idCompraEstado;
$datos['idCompra'] = $idCompra;
$datos['idCompraEstadoTipo'] = $idCompraEstadoTipo;
$datos['ceFechaIni'] = $ceFechaIni;
$datos['ceFechaFin'] = $fecha_actual;
$datos['accion'] = "editarEstado";

$respuesta = $compraEstado->abm($datos);

if ($respuesta) {
    echo json_encode(array("success" => true));
} else {
    echo "no anduvo";
}
