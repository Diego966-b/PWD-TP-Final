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
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>".$objProducto->getProNombre()."</h5>";
                    echo "<p class='card-text'>Precio: $ ".$objProducto->getProPrecio()."</p>";
                    echo "<p class='card-text'>".$objProducto -> getProDetalle()."</p>";
                    echo "<p class='card-text'>Stock: ".$objProducto->getProCantStock()."</p>";
                    echo "<a href='#' class='btn btn-primary'>Agregar al carrito</a>";
                    echo "</div></div></div>";
                }
            }
        }
        else
        {
            echo "<p>No hay productos cargados</p>";
        }
        echo '</div>';
        echo '</div>';
        include_once($ESTRUCTURA."/pie.php"); 
    ?>
</body>
</html>