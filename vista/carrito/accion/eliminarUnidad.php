<?php
include_once("../../../config.php");
//include_once($ESTRUCTURA . "/header.php"); 
//include_once($ESTRUCTURA . "/cabeceraBD.php");

$colDatos = data_submitted();
$idProducto = $colDatos["idProducto"];
//$objSession->eliminarUnidad($idProducto);

$objSession = new Session();
$carrito = $_SESSION['carrito'];
$nuevoCarrito = array();


print_r($carrito);
/*
for ($i = 0; $i < count ($carrito); $i++)
{
    if ($idProducto <> $arrayProducto[$i]["idProducto"]) {
        // Agrego el producto al nuevo carrito si no coincide con el ID a eliminar
        array_push($nuevoCarrito, $arrayProducto);
    }
}
*/

foreach ($carrito as $arrayProducto) {
    if ($idProducto == $arrayProducto["idProducto"]) {
        // Agrego el producto al nuevo carrito si no coincide con el ID a eliminar
        
        array_push($nuevoCarrito, $arrayProducto);
    }
}

if (count($nuevoCarrito) == 0) {
    // Borro carrito
    unset($_SESSION["carrito"]);
} else {
    // Actualizo el carrito en la sesión
    $_SESSION["carrito"] = $nuevoCarrito;
}
?>
