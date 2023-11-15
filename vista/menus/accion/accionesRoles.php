<?php
include_once "../../../config.php";
$data = data_submitted();
$objMenuRol = new AbmMenuRol();
// $listaMenuRol=$objMenuRol->buscar(null);

$respuesta = $objMenuRol->abm($data);

if($respuesta){
    echo json_encode(array("success" => true));
}else{
    echo "no anduvo";
}

?>