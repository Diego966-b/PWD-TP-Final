<?php
include_once "../../config.php";
$data = devolverDatos();

$respuesta = false;
if (isset($data['idProducto'])){
   
   $objC = new AbmProducto();
    $respuestaAbm = $objC->abm($data);
    
    if (!$respuestaAbm["exito"]){

        $sms_error = $respuestaAbm["mensaje"];
        
    }else $respuesta =true;
    
}
$retorno= array();
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    
    $retorno['errorMsg']=$sms_error;
    
}

echo json_encode($retorno);




?>