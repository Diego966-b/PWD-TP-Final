<?php
include_once('../estructura/Cabecera.php');
if($objSession->getVista()!=NULL){
    if ($objSession->getVista()->getIdRol() == 2) {
        $objUsuario = $objSession->getUsuario();
        if ($objUsuario != null) {
        $objCompra = new C_Compra();
        $idUsuario["idUsuario"] = $objUsuario->getIdUsuario();
        $arrayCompra = $objCompra->buscar($idUsuario);
        if ($arrayCompra != null) {
            $objCompraEstado = new C_CompraEstado();
            $arrayComprasRealiazadas = $objCompraEstado->buscarCompras($arrayCompra);
            if (count($arrayComprasRealiazadas) > 0) {
?>
            <div style="margin-bottom: 15%;">
                <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title text-white" id="exampleModalToggleLabel">Productos de la compra</h1>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body row">
                                <div>
                                    <?php
                                    ?>
                                    <table id="lista__carrito" class="table table-dark">
                                        <tr>
                                            <th>Imagen</th>
                                            <th>Nombre</th>
                                            <th>Descripcion</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="exampleModalToggle1" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title text-white" id="exampleModalToggleLabel">Historial de compra</h1>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body row">
                                    <div>
                                        <?php
                                        ?>
                                        <table id="seguimiento_compra" class="table table-dark">
                                            <tr>
                                                <th>ID Estado</th>
                                                <th>Nombre Usuario</th>
                                                <th>Estado</th>
                                                <th>Fecha de Inicio</th>
                                                <th>Fecha de Fin</th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <table class="container mt-5 table table-dark table-hover">
                    <tr>
                        <th>IdCompra</th>
                        <th>Estado</th>
                        <th>Ver productos</th>
                        <th>Historial Compra</th>
                    </tr>
                    <?php
                    if ($arrayComprasRealiazadas != null) {
                        foreach ($arrayComprasRealiazadas as $compraRealizada) {
                            echo '
                            <tr>
                                <td>' . $compraRealizada->getCompra()->getIdCompra() . '</td>
                                <td>' . $compraRealizada->getCompraEstadoTipo()->getCetDescripcion() . '</td>
                                <td class="d-none">' . $compraRealizada->getCeFechaIni() . '</td>
                                <td class="d-none">' . $compraRealizada->getCeFechaFin() . '</td>
                                <td class="d-none" id="idCompra">' . $compraRealizada->getIdCompraEstado() . '</td>
                                <td><a class="link-light" id="ver_productos_compras" data-bs-toggle="modal" href="#exampleModalToggle2" role="button"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-list-check" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                                </svg></a></td>
                                <td><a class="link-light" id="ver_historial" data-bs-toggle="modal" href="#exampleModalToggle1" role="button"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                                <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z"/>
                                <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z"/>
                                <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
                              </svg></a></td>
                            </tr>
                        ';
                        }
                    }
                    ?>
                </table>
            </div>
<?php
        }
    }
    if ($arrayCompra == null || count($arrayComprasRealiazadas) == 0) {
        echo "<h2 class='text-warning text-center' style='margin-bottom:20%;margin-top:5%'> Todavia no realizaste ninguna compra! </h2>";
    }
}
    }else{
        header('Location: ../paginas/home.php');
    }
}else{
    header('Location: ../paginas/home.php');
}
include_once("../estructura/Pie.php")
?>
<script src="../js/verProductoMisCompras.js"></script>
<script src="../js/verHistorialCompra.js"></script>