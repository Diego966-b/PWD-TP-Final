<?php
include_once("../../config.php");
$pagSeleccionada = "Mis Compras";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once($ESTRUCTURA . "/header.php"); ?>
    <?php include_once($ESTRUCTURA . "/cabeceraBD.php");

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
    } ?>
</head>

<body>
    <div id="filtro-opacidad">
        <div id="contenido-perfil">
            <br>
            <br>
            <div style="margin-bottom: 80px;">
                <div class="container text-center p-4 mt-3 cajaLista">
                    <h2>Lista de Compras </h2>
                    <div class="table-responsive">
                        <table class="table  m-auto">
                            <thead class="table-dark fw-bold">
                                <tr>
                                    <th scope="col">IdCompra</th> <!--IdCOmpra--->
                                    <th scope="col">Productos Compra</th>
                                    <th scope="col">Precio Total</th>
                                    <th scope="col">Fecha de la compra</th>
                                    <th scope="col">Estado de la compra</th> <!--Muestra el estado, iniciada/cancelada/finalizada/etc--->
                                    <th scope="col">Acciones</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $objCompraEstadoTipo = new AbmCompraEstadoTipo();
                                $objCompra = new AbmCompra();
                                $objProducto = new AbmProducto();
                                $objCompraEstado = new AbmCompraEstado();
                                $objCompraItem = new AbmCompraItem();

                                $listadoProducto = $objProducto->buscar(null);
                                $listadoCompra = $objCompra->buscar(null);
                                $listadoCompraEstadoTipo = $objCompraEstadoTipo->buscar(null);
                                $listarCompraEstado = $objCompraEstado->buscar(null);
                                $listadoCompraItem = $objCompraItem->buscar(null);
                                $arrayIdCompraItem = [];
                                foreach ($listadoCompra as $compra) {
                                    echo '<tr>';
                                    $total = 0;
                                    $arrayTotal = [];

                                    if ($objSession->getUsuario()->getIdUsuario() == $compra->getObjUsuario()->getIdUsuario()) {

                                        echo '<td>' .  $compra->getIdCompra() . '</td>';
                                        echo '<td>';

                                        foreach ($listadoProducto as $producto) {

                                            foreach ($listadoCompraItem as $item) {

                                                if ($item->getObjCompra()->getIdCompra() == $compra->getIdCompra()) {

                                                    if ($item->getObjProducto()->getIdProducto() == $producto->getIdProducto()) {


                                                        echo  $item->getObjProducto()->getProNombre() . "x" . $item->getCiCantidad() . '<br>';
                                                    }
                                                }
                                            }
                                        }
                                        echo '</td>';



                                        echo '<td>';
                                        echo "$" . $item->getObjProducto()->getProPrecio() * $item->getCiCantidad();
                                        echo '</td>';


                                        echo '<td>' . $compra->getCoFecha() . '</td>';

                                        echo '<td>';
                                        foreach ($listarCompraEstado as $estado) {
                                            if ($estado->getObjCompra()->getIdCompra() == $compra->getIdCompra()) {
                                                $idCompraEstado = $estado->getObjCompraEstadoTipo()->getIdCompraEstadoTipo();

                                                $ultimoIdCompraEstado = $estado->getIdCompraEstado();
                                                $ultimoEstado = $estado;
                                            }
                                        }
                                        echo  "Estado: " . $ultimoEstado->getObjCompraEstadoTipo()->getCetDescripcion() . '<br>';
                                        echo '</td>';

                                        echo '<td>';

                                        if ($idCompraEstado == 4) {
                                            echo '<p class="text-danger">La compra ya fue cancelada</p>';
                                        } else if ($idCompraEstado == 1) {
                                            echo '<form id="formulario" method="post">';
                                            echo '<input type="button" value="Cancelar Compra" class="btn btn-danger" id="cancelar-' . $compra->getIdCompra() . '" onclick="eliminarCompra(' . $compra->getIdCompra() . ',' . $estado->getIdCompraEstado() . ')">';
                                            echo '</form>';
                                        } else {
                                            echo "Su compra ya esta en camino";
                                        }
                                        echo '</td>';
                                    }
                                    echo '</tr>';
                                }



                                ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php include_once($ESTRUCTURA . "/pie.php"); ?>
    <script src="./js/cancelarCompra.js"> </script>
</body>

</html>