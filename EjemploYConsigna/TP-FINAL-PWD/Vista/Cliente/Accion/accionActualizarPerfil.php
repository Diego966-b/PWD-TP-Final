<?php
include_once("../../../configuracion.php");

$datos = data_submitted();
$objUsuario = new C_Usuario();

    if ($objUsuario->modificacion($datos)) {
        echo json_encode(array('success'=>1));
    } else {
        echo json_encode(array('success'=>0));
    }
?>