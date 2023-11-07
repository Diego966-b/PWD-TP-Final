<?php
include_once("../../../configuracion.php");
$datos=data_submitted();
$objUsuario=new C_Usuario();
$usuarioModificado=$objUsuario->modificacion($datos);
//rol Agregado da falso cuando no se pudo o cuando no se modifico el rol.VER
$rolAgregado=$objUsuario->cambiarRoles($datos);

if($usuarioModificado && !$rolAgregado){
    //solo modifico el usuario: Datos modificados con exito!
    echo json_encode(array('success'=>1));
}else if($rolAgregado && !$usuarioModificado){
    //solo modifico roles: Rol agregado con exito!
    echo json_encode(array('success'=>2));
}else if($rolAgregado && $usuarioModificado){
    //Roles y datos modificados con exito!
    echo json_encode(array('success'=>3));
}else if(!$rolAgregado && !$usuarioModificado){
    //No se modificó ningun dato.
    echo json_encode(array('success'=>0));
}
?>