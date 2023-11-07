<?php
include_once('../../configuracion.php');

$objSession=new C_Session();
$sesionCerrada=$objSession->cerrar();
if($sesionCerrada){
    echo json_encode(array('success'=>1));
}else{
    echo json_encode(array('success'=>0));
}
?>