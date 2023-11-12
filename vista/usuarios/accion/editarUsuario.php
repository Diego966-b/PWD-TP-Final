<?php
include_once("../../../config.php");
$datos= devolverDatos();
$abmUsuario= new AbmUsuario;
$respuesta=$abmUsuario->abm($datos);
echo "Mensaje 1:".$respuesta["mensaje"];

$abmUsuarioRol= new AbmUsuarioRol;
$datos2["idRol"]=$datos["idRol"];
$datos2["idUsuario"]=$datos["idUsuario"];
$datos2["accion"]="editar";

print_r($datos2);

$respuesta2=$abmUsuarioRol->abm($datos2);
echo "Mensaje 2:". $respuesta2["mensaje"];
if($respuesta["exito"]&& $respuesta2["exito"]){
    echo "edito todo quedo flamita";
    header("Refresh: 3; URL='$VISTA/usuarios/usuarios.php'");

}
?>