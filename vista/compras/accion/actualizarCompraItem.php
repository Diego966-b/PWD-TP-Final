<?php
    include_once('../../../config.php'); 
    $data = data_submitted();
    $objAbmCompraItem= new AbmCompraItem();
    $data ["accion"] = "borrarItem";
    $resultado = $objAbmCompraItem -> abm($data);

    if ($resultado["exito"]) {
        echo json_encode(array("success" => true));
    } else {
        echo "no anduvo";
    }
?>
