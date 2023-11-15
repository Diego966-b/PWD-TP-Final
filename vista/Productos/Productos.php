<?php
    include_once("../../config.php");
    $pagSeleccionada = "Productos";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once($ESTRUCTURA."/header.php"); ?>
    <?php include_once($ESTRUCTURA."/cabeceraBD.php"); ?>
</head>
<body>
    <?php
        if ($objSession -> validar())
        {
            $tienePermiso = $objSession -> tienePermisoB($objSession->getUsuario());
            if (!$tienePermiso)
            {
                header("Refresh: 3; URL='$VISTA/acceso/login.php'");
            }
        }
        else
        {
            header("Refresh: 3; URL='$VISTA/acceso/login.php'");
        }
        echo '<div class="container mt-5">';
        echo '<h1>Productos a la venta</h1>';
        echo '<div class="row">';
        $abmProducto = new AbmProducto();
        $listaProductos = $abmProducto -> buscar(null);
        if (count($listaProductos) > 0)
        {
            foreach ($listaProductos as $objProducto)
            {
                if ($objProducto->getProDeshabilitado() == null)
                {
                    echo "<div class='col-md-4 mb-4'>";
                    echo "<div class='card'>";
                    echo "<div class='row no-gutters'>"; 
                    echo "<div class='col-md-4 d-flex align-items-center justify-content-center p-3'>";
                    echo "<img class='card-img' src=".$VISTA."/imagenes/".$objProducto->getProImagen()." alt='Imagen del producto'>";
                    echo "</div>"; 
                    echo "<div class='col-md-8'>"; 
                    echo "<div class='card-body'>";
                    echo "<form id='formProductos' name='formProductos' method='post'>";
                        echo "<h5 class='card-title'>".$objProducto->getProNombre()."</h5>";
                        echo "<p class='card-text'>Precio: $ ".$objProducto->getProPrecio()."</p>";
                        echo "<p class='card-text'>".$objProducto->getProDetalle()."</p>";
                        echo "<p class='card-text'>Stock: ".$objProducto->getProCantStock()."</p>";
                        echo "<label for='proCantidad'>Cantidad:</label>";
                        echo "<input type='number' class='card-text proCantidad' name='proCantidad' value='1' id='proCantidad-" . $objProducto->getIdProducto() . "'>";
                        echo "<div class='error-container' id='error-proCantidad-" . $objProducto->getIdProducto() . "'></div>"; // Contenedor de errores
                        echo "<br><br>";
                        if ($objProducto->getProCantStock() == 0)
                        {
                            echo '<button class="btn btn-primary mx-1" disabled onclick="agregarItemCarrito('
                            . $objProducto->getIdProducto() . ', \'' . $objProducto->getProImagen() . '\', '
                            . $objProducto->getProPrecio() . ', \'' . $objProducto->getProDetalle() . '\', \''
                            . $objProducto->getProNombre() . '\', ' . $objProducto->getProCantStock() . ')">Agregar al carrito</button>';
                        }
                        else
                        {
                            echo '<button class="btn btn-primary mx-1" onclick="agregarItemCarrito('
                            . $objProducto->getIdProducto() . ', \'' . $objProducto->getProImagen() . '\', '
                            . $objProducto->getProPrecio() . ', \'' . $objProducto->getProDetalle() . '\', \''
                            . $objProducto->getProNombre() . '\', ' . $objProducto->getProCantStock() . ')">Agregar al carrito</button>';
                        }
                        echo "";
                    echo "</form>";
                    echo "</div>"; 
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            }
        }
        else
        {
            echo "<p>No hay productos cargados</p>";
        }
        echo '</div></div>';
        print_r($_SESSION);
        include_once($ESTRUCTURA."/pie.php"); 
        // agrgagr validaciones js
    ?>
    <script src="<?php echo $JS; ?>/validar.js"></script>
    <script src="./js/agregarItem.js"></script>
</body>
</html>