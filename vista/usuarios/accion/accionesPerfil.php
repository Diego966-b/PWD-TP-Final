<?php
include_once "../../../config.php";
$data = data_submitted();
$objUsuario = new AbmUsuario();
$respuesta = $objUsuario->abm($data);
if($respuesta){
    echo json_encode(array("success" => true));
}else{
    echo "no anduvo";
}
?>