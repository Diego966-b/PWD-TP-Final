<?php
include_once("../../../config.php");
$colDatos = data_submitted();
$idProducto = $colDatos["idProducto"];
$objSession = new Session();
$resp=$objSession->eliminarUnidad($idProducto);
if($resp){
    echo json_encode(array("success" => true));
}else{
    echo "no anduvo";
}
?>
