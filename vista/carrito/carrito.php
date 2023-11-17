<?php
    include_once("../../config.php");
    $pagSeleccionada = "Carrito";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once($ESTRUCTURA . "/header.php"); ?>
    <?php 
        include_once($ESTRUCTURA . "/cabeceraBD.php");
        if ($objSession->validar()) {
            $tienePermiso = $objSession->tienePermisoB($objSession->getUsuario());
            if (!$tienePermiso) {
                header("Refresh: 0; URL='$VISTA/acceso/login.php'");
            } 
            $estadoPagina = $objSession->estadoMenu();
            if (!$estadoPagina) {
                header("Refresh: 0; URL='$VISTA/home/index.php'");
            }
        } else {
            header("Refresh: 0; URL='$VISTA/acceso/login.php'");
        }
    ?>
</head>
<body id="filtro-opacidad" >
    <div id="contenido-perfil" style="margin-top: 0px;">
            <br>
            <br>
            <?php
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
                        echo "<p>" . $objProducto->getProDetalle() . "</p>";
                        echo "<input type='hidden' value=" . $objProducto->getIdProducto() . " name='idProducto' id='idProducto'>";
                        echo '<button class="btnRestar btn btn-danger mx-1" onclick="eliminarUnidad('.$objProducto->getIdProducto().')">Eliminar item</button>';
                        $totalPagar = (($objProducto->getProPrecio()) * $producto["proCantidad"]) + $totalPagar;
                        echo "</div>";
                        echo "</div>";
                    }
                    $jsonCarrito = json_encode($carrito);

                    echo "<script>var carrito = $jsonCarrito;</script>";
                    echo '</div>';
                    echo '<div class="container">';
                    echo '<div class="row">';
                    echo '<div class="col-12">';
                    echo "<p class='fs-4'>Total a pagar: $ " . $totalPagar . "</p>";
                    echo '<button class="btn btn-primary btn-pago btn-lg mx-1 float-end" onclick="pagarCarrito()">Pagar</button>';
                    echo '</div></div></div>';
                    echo "<br><br><br><br><br>";
                } else {
                    echo '<div id="filtro-opacidad">';
                    echo '<div id="contenido"> 
                    <h2>No hay items en el carrito</h2>
                    <a href="' . $VISTA . '/productos/productos.php?rol='.$idSeleccionado.'"><button class="btn btn-warning"> Ir a la Tienda</button></a>     
                    </div>';
                echo '</div >';
            }
            ?>
    </div>
    <script src="./js/funcionesCarrito.js"></script>
    <?php include_once($ESTRUCTURA . "/pie.php"); ?>
</body>
</html>