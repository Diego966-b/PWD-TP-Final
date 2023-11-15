<?php
include_once "../../../config.php";
$data = data_submitted();
$objMenu = new AbmMenu();
$respuesta = $objMenu->abm($data);

if($respuesta){
    echo json_encode(array("success" => true));
}else{
    echo "no anduvo";
}

?>