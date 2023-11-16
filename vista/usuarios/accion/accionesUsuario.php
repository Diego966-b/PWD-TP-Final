<?php
include_once "../../../config.php";
$data = data_submitted();

$objUsuario = new AbmUsuario();
$objAbmCompra = new AbmCompra();
$objAbmCompraEstado = new AbmCompraEstado();
$objAmbCompraItem = new AbmCompraItem();
$respuesta = $objUsuario->abm($data);

if($data["accion"] == "editar"){
    $data["accion"]="actualizarRol";
    $respuesta=$objUsuario->abm($data);
}

if($data["accion"] == "bajaCompra"){
    $respuesta = $objAbmCompra -> abm($data);
}
if($respuesta["exito"]){
    echo json_encode(array("success" => true));
}else{
    echo "no anduvo";
}

?>