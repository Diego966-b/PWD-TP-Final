<?php
include_once("../../config.php");
$pagSeleccionada = "Gestionar Compras";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once($ESTRUCTURA . "/header.php"); ?>
    <?php include_once($ESTRUCTURA . "/cabeceraBD.php");
    if ($objSession->validar()) {
        $tienePermiso = $objSession->tienePermisoB($objSession->getUsuario());
        if (!$tienePermiso) {
            header("Refresh: 3; URL='$VISTA/acceso/login.php'");
        }
        // agreegar para todas las paginas 
        $estadoPagina = $objSession->estadoMenu();
        if (!$estadoPagina) {
            header("Refresh: 3; URL='$VISTA/home/index.php'");
        }
    } else {
        header("Refresh: 3; URL='$VISTA/acceso/login.php'");
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
                                    <th scope="col">IdCompra</th>
                                    <th scope="col">Fecha de la compra</th>
                                    <th scope="col">Nombre del usuario</th>
                                    <th scope="col">Estados de la compra</th>
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

                                foreach ($listadoCompra as $compra) {
                                    $total = 0;
                                    $arrayTotal = [];
                                    echo '<tr>';
                                    foreach ($listadoProducto as $producto) {
                                        foreach ($listadoCompraItem as $item) {
                                            if ($item->getObjCompra()->getIdCompra() == $compra->getIdCompra()) {
                                                if ($item->getObjProducto()->getIdProducto() == $producto->getIdProducto()) {
                                                    array_push($arrayTotal,  $total);
                                                }
                                            }
                                        }
                                    }

                                    echo '<td>' .  $compra->getIdCompra() . '</td>';
                                    echo '<td>' . $compra->getCoFecha() . '</td>';
                                    echo '<td>' . $compra->getObjUsuario()->getUsNombre() . '</td>';

                                    echo '<td>';
                                    foreach ($listarCompraEstado as $estado) {
                                        if ($estado->getObjCompra()->getIdCompra() == $compra->getIdCompra()) {
                                            echo  "Estado: " . $estado->getObjCompraEstadoTipo()->getCetDescripcion() . '<br>';
                                            echo   "Fecha Inicio estado: " . $estado->getceFechaIni() . '<br>';
                                            echo  "Fecha fin de estado: " . $estado->getceFechaFin() . '<br>';
                                            $ultimoIdCompraEstado = $estado->getIdCompraEstado();
                                        }
                                    }
                                    echo '</td>';

                                    echo '<td>' .
                                        '<form id="formSelect">' .
                                        '<select name="estado" id="estado-' . $compra->getIdCompra() . '">';
                                    foreach ($listadoCompraEstadoTipo as $estadoTipo) {
                                        echo '<option value=" ' . $estadoTipo->getIdCompraEstadoTipo() . '"> ' . $estadoTipo->getCetDescripcion() . '</option>';
                                    }
                                    echo '</select>';
                                    echo '<button type="button" class="btn btn-primary" onclick="enviarDatos(' . $compra->getIdCompra() . ',\'' . $ultimoIdCompraEstado . '\',' . ')">Guardar</button>';
                                    echo '</form>';
                                    echo '</td>';
                                }
                                //codigo va aca 
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
    <script src="js/accionesCompra.js"></script>
</body>


</html>