<?php
include_once('../../../config.php');
$data = data_submitted();

$idCompra = $data['idCompra'];
$idCompraEstadoTipo = $data['idCompraEstadoTipo'];
//cargo el ultimo compra estado, como viene uno solo(busca por su id) selecciono el arreglo en posicion 0
$buscaCompra['idCompraEstado']=$data['idCompraEstado'];
$compraEstado = new AbmCompraEstado();
$arrObjCompraEstado = $compraEstado->buscar($buscaCompra);
$ObjCompraEstado = $arrObjCompraEstado[0];
// seteo el id de ese objeto CompraEstado (es el mismo que me mando por ajax 'idCompraEstado'), tambien las fechas que tenia este estado
$idCompraEstado = $ObjCompraEstado->getIdCompraEstado();
$ceFechaIni = $ObjCompraEstado->getCeFechaIni();
$ceFechaFin = $ObjCompraEstado->getCeFechaFin();
// fecha actual
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha_actual = date("Y-m-d H:i:s");
// seteo el arreglo de datos para las acciones AmbCompraEstado
$datos['accion'] = "editarEstado";
$datos['idCompraEstado'] = $idCompraEstado; //id del ultimo estado que tuvo la compra
$datos['idCompra'] = $idCompra; // id de la compra
$datos['idCompraEstadoTipo'] = $idCompraEstadoTipo; //id del tipo de estado de la compra
$datos['ceFechaIni'] = $ceFechaIni; // fecha Inicio estado
$datos['ceFechaFin'] = $fecha_actual;// fecha Fin estado

$respuesta = $compraEstado->abm($datos);

if ($respuesta) {
    echo json_encode(array("success" => true));
} else {
    echo "no anduvo";
}
