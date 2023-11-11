<?php
include_once "../../config.php";
$data = data_submitted();


    $objC = new AbmProducto();
    $respuesta = $objC->baja($data);
if($respuesta){
    echo json_encode(array('success'=>true));
}else{
    echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>