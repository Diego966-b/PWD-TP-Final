<?php 
include_once "../../config.php";
$data = devolverDatos();
$objControl = new AbmProducto();
$list = $objControl->buscar($data);
$arreglo_salida =  array();
foreach ($list as $elem ){
    
    $nuevoElem['idProducto'] = $elem->getIdProducto();
    $nuevoElem["proNombre"]=$elem->getProNombre();
    $nuevoElem["proDetalle"]=$elem->getProDetalle();
    //$nuevoElem["imagen"]=$elem->getImagen();   
    $nuevoElem["proCantStock"]=$elem->getProCantStock();
    
   
    array_push($arreglo_salida,$nuevoElem);
}
//verEstructura($arreglo_salida);
//print_r($arreglo_salida);
echo json_encode($arreglo_salida);

?>