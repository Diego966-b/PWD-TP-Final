<?php
include_once "../../config.php";
$data = data_submitted();
$respuesta = false;
$sms_error = "";
$retorno = array();

$id = htmlspecialchars($data['idProducto']);
$proNombre = htmlspecialchars($data['proNombre']);
$proDetalle = htmlspecialchars($data['proDetalle']);
$imagen = htmlspecialchars($data['imagen']);
$proCantStock = htmlspecialchars($data['proCantStock']);


    if (isset($id)) {
        $objC = new AbmProducto();
        $respuesta = $objC->modificacion($data);

        if ($respuesta) {
            echo json_encode(array(
                'idProducto' => $id,
                'proNombre' => $proNombre,
                'proDetalle' => $proDetalle,
                'imagen' => $imagen,
                'proCantStock' => $proCantStock
            ));
            
        }else{
            
                echo json_encode(array('errorMsg'=>'Some errors occured.'));
            
        }
    }


?>
