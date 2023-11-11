<?php 
include_once "../../config.php";
$data = devolverDatos();
$respuesta = false;
if (isset($data['proNombre'])){
        $objC = new AbmProducto();
        $respuesta = $objC->alta($data);
        if (!$respuesta){
            $mensaje = " La accion  ALTA No pudo concretarse";
            
        }
}
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    
    $retorno['errorMsg']=$mensaje;
   
}
 echo json_encode($retorno);
?>