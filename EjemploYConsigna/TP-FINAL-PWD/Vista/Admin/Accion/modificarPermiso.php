<?php
include_once("../../../configuracion.php");

$datos=data_submitted();
$objMenu=new C_Menu();
$objMenuRol=new C_MenuRol();
$menuModificado=$objMenu->modificacion($datos);
$rolModificado=$objMenuRol->modificacion($datos);
if($menuModificado && $rolModificado){
    //Roles y datos modificados con exito!
    echo json_encode(array('success'=>3));
}else if($menuModificado && !$rolModificado){
    //solo modifico el menu: Datos modificados con exito!
    echo json_encode(array('success'=>2));
}else if(!$menuModificado && $rolModificado){
    //solo modifico roles: Rol agregado con exito!
    echo json_encode(array('success'=>1));
}else if(!$rolModificado && !$menuModificado){
    //No se modificó ningun dato.
    echo json_encode(array('success'=>0));
}

?>