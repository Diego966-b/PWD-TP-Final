<?php
include_once("../../../configuracion.php");

$datos=data_submitted();
$objMenu=new C_Menu();
$menuHabilitado=$objMenu->habilitar($datos);
if($menuHabilitado){
    echo json_encode(array('success'=>1));
}else{
    echo json_encode(array('success'=>0));
}
?>