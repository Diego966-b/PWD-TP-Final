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
                    echo "<form id='formCarrito' name='formCarrito' method='post'>";
                    echo "<h5 class='card-title'>".$objProducto->getProNombre()."</h5>";
                    echo "<p class='card-text'>Precio: $ ".$objProducto->getProPrecio()."</p>";
                    echo "<p class='card-text'>".$objProducto->getProDetalle()."</p>";
                    echo "<p class='card-text'>Stock: ".$objProducto->getProCantStock()."</p>";
                    echo "<input type='number'class='card-text proCantidad' name='proCantidad' id='proCantidad'>Cantidad: ";
                    echo "<input type='hidden' value=".$objProducto->getIdProducto()." name='idProducto' id='idProducto'>";
                    echo '<button class="btn btn-primary mx-1" onclick="agregarItemCarrito('.$objProducto->getIdProducto().')">Agregar al carrito</button>';
                    //echo "<input type='submit' class='btn btn-primary btn-agregar-item' name='btn-enviar' id='btn-enviar' value='Agregar al carrito'>";
                    echo "</div>"; 
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</form>";
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
    ?>
    <script src="./js/agregarItem.js"></script>
</body>
</html>