<?php
include_once('../estructura/Cabecera.php');
if($objSession->getVista()!=NULL){
    if ($objSession->getVista()->getIdRol() == 1) {
        header('Location: listaUsuarios.php');
    } else {
        header('Location: ../paginas/home.php');
    }
}else {
    header('Location: ../paginas/home.php');
}
?>