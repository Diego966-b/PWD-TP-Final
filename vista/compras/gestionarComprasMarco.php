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
            header("Refresh: 0; URL='$VISTA/acceso/login.php'");
        }
        // agreegar para todas las paginas 
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
                                    <th scope="col">IdCompra</th>
                                    <th scope="col">Fecha de la compra</th>
                                    <th scope="col">Nombre del usuario</th>
                                    <th scope="col">Precio Total</th>
                            <th scope="col">Estado compra</th> <!--Muestra el estado, iniciada/cancelada/finalizada/etc--->
                            <th scope="col">Productos</th>
                            <th scope="col">Historial Estados</th>
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
                        $listaCompraEstado = $objCompraEstado->buscar(null);
                        // print_r($listaCompraEstado);    
                        $listadoCompraItem = $objCompraItem->buscar(null);
                        // POSIBLE MODULARIZACION

                        // espacio para convertir el arreglo de $listadoCOmpraEstado en Arrays y no objetos
                        $arrayParaJson = [];
                        foreach ($listaCompraEstado as $compraEstado) {
                            $arrayDatos = [];
                            $arrayObjeto = dismount($compraEstado);
                            foreach ($arrayObjeto as $clave => $valor) {
                                if (strncmp("obj", $clave, 3) === 0) {
                                    $arrayDatos1 = [];
                                    $arrayObjeto1 = dismount($valor);
                                    foreach ($arrayObjeto1 as $clave1 => $valor1) {
                                        if (strncmp("obj", $clave1, 3) === 0) {
                                            $objArray1 = dismount($valor1);
                                            $arrayDatos1[$clave1] = $objArray1;
                                        } else {
                                            $arrayDatos1[$clave1] = $valor1;
                                        }
                                    }
                                    $objArray = $arrayDatos1;
                                    $arrayDatos[$clave] = $objArray;
                                } else {
                                    $arrayDatos[$clave] = $valor;
                                }
                            }
                            array_push($arrayParaJson, $arrayDatos);
                        }
                        $JsonListaCompraEstado = json_encode($arrayParaJson, JSON_PRETTY_PRINT);
                        // PRueba cosas raras 2.0 
                        $arrayParaJson1 = [];
                        foreach ($listadoCompraItem as $compraEstado) {
                            $arrayDatos = [];
                            $arrayObjeto = dismount($compraEstado);
                            foreach ($arrayObjeto as $clave => $valor) {
                                if (strncmp("obj", $clave, 3) === 0) {
                                    $arrayDatos1 = [];
                                    $arrayObjeto1 = dismount($valor);
                                    foreach ($arrayObjeto1 as $clave1 => $valor1) {
                                        if (strncmp("obj", $clave1, 3) === 0) {
                                            $objArray1 = dismount($valor1);
                                            $arrayDatos1[$clave1] = $objArray1;
                                        } else {
                                            $arrayDatos1[$clave1] = $valor1;
                                        }
                                    }
                                    $objArray = $arrayDatos1;
                                    $arrayDatos[$clave] = $objArray;
                                } else {
                                    $arrayDatos[$clave] = $valor;
                                }
                            }
                            array_push($arrayParaJson1, $arrayDatos);
                        }
                        $JsonListaCompraItem = json_encode($arrayParaJson1, JSON_PRETTY_PRINT);


                        // print_r($arrayParaJson);
                        //  fin de espacio de cosas raras
                        foreach ($listadoCompra as $compra) {
                            echo '<tr>';
                            $total=0;
                            foreach ($listadoProducto as $producto) {
                                foreach ($listadoCompraItem as $item) {
                                    if ($item->getObjCompra()->getIdCompra() == $compra->getIdCompra()) {
                                        if ($item->getObjProducto()->getIdProducto() == $producto->getIdProducto()) {
                                            //  echo  $item->getObjProducto()->getProNombre() . "$" . $item->getObjProducto()->getProPrecio(). " x ".$item->getCiCantidad(). "<br>";
                                            $total += $item->getObjProducto()->getProPrecio() * $item->getCiCantidad();
                                            // echo "$" . $item->getObjProducto()->getProPrecio() * $item->getCiCantidad() ;                            
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
                            }
                            echo '<td>' .  $compra->getIdCompra() . '</td>';
                            echo '<td>' . $compra->getCoFecha() . '</td>';
                            echo '<td>' . $compra->getObjUsuario()->getUsNombre() . '</td>';
                            echo '<td>' . $total . '</td>';

                            

                            echo '<td>';
                            foreach ($listaCompraEstado as $estado) {
                                if ($estado->getObjCompra()->getIdCompra() == $compra->getIdCompra()) {
                                    // echo  "Estado: " . $estado->getObjCompraEstadoTipo()->getCetDescripcion() . '<br>';
                                    // echo   "Fecha Inicio estado: " . $estado->getceFechaIni() . '<br>';
                                    // echo  "Fecha fin de estado: " . $estado->getceFechaFin() . '<br>';
                                    $objUltimoEstadoCompra = $estado;
                                    $ultimoIdCompraEstado = $estado->getIdCompraEstado();
                                }
                            }
                            echo  "Estado: " . $estado->getObjCompraEstadoTipo()->getCetDescripcion() . '<br>';
                            echo   "Fecha Inicio estado: " . $estado->getceFechaIni() . '<br>';
                            echo  "Fecha fin de estado: " . $estado->getceFechaFin() . '<br>';
                            echo '</td>';
                            echo '<td>';
                            echo '<button type="button" class="btn btn-primary" onclick="abrirModalProductos(' . $compra->getIdCompra() . ',' . $objUltimoEstadoCompra->getObjCompraEstadoTipo()->getIdCompraEstadoTipo(). ')"> Ver prod</button>';
                            echo '</td>';
                            echo '<td>';
                            echo '<button type="button" class="btn btn-primary" onclick="abrirModalEstados(' . $compra->getIdCompra() . ')">historial</button>';
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
        <div id="resultado">

        </div>
    </div>
<!-- Modal mostrar estados  -->
    <div class="modal fade" id="estadosModal" name="estadosModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form name="editarForm" id="editarForm" method="post">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-light">
                        <h1 class="modal-title fs-5" id="editarModalLabel">Historial Estados</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center  ">
                        <div name="contenidoModal" id="contenidoModal"></div>
                    </div>
                    <div class="modal-footer  bg-dark">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<!-- Modal mostrar Productos  -->
<div class="modal fade" id="productosModal" name="productosModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form name="editarForm" id="editarForm" method="post">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-light">
                        <h1 class="modal-title fs-5" id="editarModalLabel">Productos de la Compra</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center  ">
                        <div name="contenidoModalProductos" id="contenidoModalProductos"></div>
                    </div>
                    <div class="modal-footer  bg-dark">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                       

                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php

    include_once($ESTRUCTURA . "/pie.php"); ?>
    <script>
        function abrirModalProductos(idComprax,idCompraEstado){
            console.log(idCompraEstado);
            var modal = document.getElementById('productosModal');
            var arregloObjetos = <?php echo $JsonListaCompraItem; ?>;//este
            var contenidoModal = document.getElementById('contenidoModalProductos');
            contenidoModal.innerHTML = ''; 
            for (var i = 0; i < arregloObjetos.length; i++) {

                var compraItem = arregloObjetos[i];
                if (compraItem.objCompra.idCompra == idComprax) {
                    contenidoModal.innerHTML += '<h3>IdCOmpraItem:' + compraItem.idCompraItem + '</h3>'+
                        '<div class="cajaLista">' +
                        '<div class="row align-items-center">'+
                        '<div class="col "><p>Producto: ' + compraItem.objProducto.proNombre  +
                        '<p>Precio por Unidad: $' + compraItem.objProducto.proPrecio  +
                        '<p>Unidades: ' + compraItem.ciCantidad  + '</div>';
                        if(idCompraEstado== 3 || idCompraEstado == 4){
                            contenidoModal.innerHTML +=  '<div class="col"><button type="button" disabled class="btn btn-secondary" onclick="eliminarItem('+compraItem.idCompraItem+','+idComprax+')">Eliminar</button> </div></div></div>';
                        }else{
                            contenidoModal.innerHTML +=   '<div class="col"><button type="button" class="btn btn-danger" onclick="eliminarItem('+compraItem.idCompraItem+','+idComprax+')">Eliminar</button> </div></div></div>';
                        }
                       
                }
            }
            $("#productosModal").modal("show");
        }

        // se deja esto aqui por que nose como sacar el php
        function abrirModalEstados(idComprax) {
            var modal = document.getElementById('estadosModal');
            var arregloObjetos = <?php echo $JsonListaCompraEstado; ?>;//este
            var contenidoModal = document.getElementById('contenidoModal');
            contenidoModal.innerHTML = ''; 
            for (var i = 0; i < arregloObjetos.length; i++) {
                var compraEstado = arregloObjetos[i];
                if (compraEstado.objCompra.idCompra == idComprax) {
                    contenidoModal.innerHTML += '<h3>ESTADO:' + compraEstado.idCompraEstado + '</h3><div class="cajaLista">' +
                        '<p> ID tipo Estado:' + compraEstado.objCompraEstadoTipo.idCompraEstadoTipo  +
                        '<p> DESCRIPCION:' + compraEstado.objCompraEstadoTipo.cetDescripcion  +
                        '<p> FECHA INICIO:' + compraEstado.ceFechaIni + ' ' +
                        '<p> FECHA FIN:' + compraEstado.ceFechaFin + '</div> </p> ';
                }
            }
            $("#estadosModal").modal("show");
        }

    </script>
    <script src="js/accionesCompra.js"></script>
</body>


</html>