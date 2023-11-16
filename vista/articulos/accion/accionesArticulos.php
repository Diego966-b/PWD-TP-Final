<?php
    include_once ("../../../config.php");
    $data = data_submitted();
    $objProducto = new AbmProducto();
    $respuesta = $objProducto->abm($data);
    if($respuesta){
        echo json_encode(array("success" => true));
    }else{
        echo "no anduvo";
    }
?>