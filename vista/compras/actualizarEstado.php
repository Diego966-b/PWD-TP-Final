<?php
include_once('../../config.php');
$data = devolverDatos();
$data['idCompraEstadoTipo'];

$idCompraEstadoTipo = $data['idCompraEstadoTipo'];
$compraEstado = new AbmCompraEstado();

$arrObjCompraEstado = $compraEstado->buscar(null);
$idCompraEstado = $arrObjCompraEstado[0]->getIdCompraEstado();
$idCompra = $arrObjCompraEstado[0]->getObjCompra()->getIdCompra();
$ceFechaIni = $arrObjCompraEstado[0]->getCeFechaIni();
$ceFechaFin = $arrObjCompraEstado[0]->getCeFechaFin();


$fecha_actual = date("Y-m-d H:i:s");

$datos['idCompraEstado'] = $idCompraEstado;
$datos['idCompra'] = $idCompra;
$datos['idCompraEstadoTipo'] = $idCompraEstadoTipo;
$datos['ceFechaIni'] = $fecha_actual;
$datos['ceFechaFin'] = $fecha_actual;
$datos['accion'] = "editar";

$respuesta = $compraEstado->abm($datos);

if ($respuesta) {
    echo json_encode(array("success" => true));
} else {
    echo "no anduvo";
}
