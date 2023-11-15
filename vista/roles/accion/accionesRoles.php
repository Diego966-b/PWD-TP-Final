<?php
include_once "../../../config.php";
$data = data_submitted();
$objRol = new AbmRol();
$respuesta = $objRol->abm($data);

if($respuesta){
    echo json_encode(array("success" => true));
}else{
    echo "no anduvo";
}

?>