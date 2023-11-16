<?php
    include_once('../../../config.php');
    $data = data_submitted();
    $data ["accion"] = "actualizarEstado";
    $abmCompraEstado = new AbmCompraEstado();
    $respuesta = $abmCompraEstado -> abm($data);
    if ($respuesta["exito"]) {
        echo json_encode(array("success" => true));
    } else {
        echo "no anduvo";
    }
?>