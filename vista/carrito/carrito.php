<?php
include_once("../../config.php");
$pagSeleccionada = "Carrito";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once($ESTRUCTURA . "/header.php"); ?>
    <?php include_once($ESTRUCTURA . "/cabeceraBD.php"); ?>
</head>

<body>
    <div id="filtro-opacidad">
        <div id="contenido-perfil">
            <br>
            <br>
    <?php
    if ($objSession->validar()) {
        $tienePermiso = $objSession->tienePermisoB($objSession->getUsuario());
        if (!$tienePermiso) {
            header("Refresh: 3; URL='$VISTA/acceso/login.php'");
        }
    } else {
        header("Refresh: 3; URL='$VISTA/acceso/login.php'");
    }

    if (isset($_SESSION['carrito'])) {
        echo '<h1 class="text-center">Carrito</h1>';
        echo '<div class="container mt-5">';
        echo '<div class="row">';
        $carrito = $_SESSION['carrito'];
        $totalPagar = 0;
        $colProductos = [];
        for ($i = 0; $i < count($carrito); $i++) {
            $abmProducto = new AbmProducto();
            $producto = $carrito[$i];
            $idProducto = $producto["idProducto"];
            $array = [];
            $array["idProducto"] = $idProducto;
            $listaProductos = $abmProducto->buscar($array);
            $objProducto = $listaProductos[0];
            echo "<div class='row mb-3 border'>";
            echo "<div class='col-md-3 mx-auto d-flex align-items-center'>";
            echo "<img class='img-fluid' src=" . $VISTA . "/imagenes/" . $objProducto->getProImagen() . " alt='Imagen del producto' style='width: 200px;'>";
            echo "</div>";
            echo "<div class='col-md-8'>";
            echo "<h5>" . $objProducto->getProNombre() . "</h5>";
            echo "<p>Precio: $ " . $objProducto->getProPrecio() . "</p>";
            //echo '<button class="btn btn-success mx-1" onclick="agregarUnidad('.$objProducto->getIdProducto().',\''.$producto["proCantidad"].'\','.')">+</button>';

            echo "<div class='parrafo' id='parrafo-" . $objProducto->getIdProducto() . "'>";
            echo "<p id='proCantidad-" . $objProducto->getIdProducto() . "' name='proCantidad' class='proCantidad'>Cantidad: " . $producto["proCantidad"] . "</p>";
            echo "</div>";

            //echo '<button class="btnRestar btn btn-danger mx-1" onclick="eliminarUnidad('.$objProducto->getIdProducto().',\''.$producto["proCantidad"].'\','.')">-</button>';
            echo "<p>" . $objProducto->getProDetalle() . "</p>";
            echo "<input type='hidden' value=" . $objProducto->getIdProducto() . " name='idProducto' id='idProducto'>";
            $totalPagar = (($objProducto->getProPrecio()) * $producto["proCantidad"]) + $totalPagar;
            echo "</div>";
            echo "</div>";

            /*
                NO SIRVE DE NADA
                $objProductoArray = [];
                $objProductoArray = dismount($objProducto);
                array_push($colProductos, $objProductoArray); 
                */
        }

        //$jsonProductos = json_encode($colProductos);
        $jsonCarrito = json_encode($carrito);
        //print_r($carrito);
        echo "<script>var carrito = $jsonCarrito;</script>";
        echo '</div>';
        echo '<div class="container">';
        echo '<div class="row">';
        echo '<div class="col-12">';
        echo "<p class='fs-4'>Total a pagar: $ " . $totalPagar . "</p>";
        // HAY QUE DARLE UN ARREGLO!!!
        echo '<button class="btn btn-primary btn-pago btn-lg mx-1 float-end" onclick="pagarCarrito(' . $colProductos . ')">Pagar</button>';
        echo '</div></div></div>';
        echo "<br><br><br><br><br>";
    } else {
        echo '<div id="filtro-opacidad">';
        echo '<div id="contenido"> 
          <h2>No hay items en el carrito</h2>
          <a href="'.$VISTA.'/productos/productos.php"><button class="btn btn-warning"> Ir a la Tienda</button></a>     
            </div>';
        echo '</div >';
    }
    ?>
    </div>
    </div>
    <script src="./js/funcionesCarrito.js"></script>
    <?php include_once($ESTRUCTURA . "/pie.php"); ?>
</body>

</html>