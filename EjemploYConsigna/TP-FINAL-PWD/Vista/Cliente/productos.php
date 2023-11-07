<?php
include_once("../estructura/Cabecera.php");
if($objSession->getVista()!=NULL){
    if ($objSession->getVista()->getIdRol() == 2) {
?>
<div class="">
    <div class="container">
        <h1 class="text-center text-white">Productos</h1>
        <hr>
    </div>
    <div class="modal fade" id="exampleModalToggle1" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title text-white" id="exampleModalToggleLabel">Detalle del Producto</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div id="content__foto__detalle" class="col-md-4">
                        <img id="foto__detalle" class="img-thumbnail" src="" alt="">
                    </div>
                    <div id="content__info__detalle" class="col">
                        <h3 id="nombre__detalle"></h3>
                        <p id="descripcion__detalle"></p>
                        <p id="cantidad_detalle"></p>
                    </div>
                </div>
                <div id="content__precio__detalle">
                    <p id="precio__detalle"></p>
                </div>
                <div class="modal-footer">
                    <form method="post" action="../Accion/accionRegistrarse.php" class="needs-validation" novalidate>
                        <input type="text" name="idProducto" id="idProducto" class="d-none">
                        <div>
                            <input type="number" name="ciCantidad" id="cantidad_input" min="1" class="form-control" placeholder="Ingrese la cantidad que desea comprar" required>
                            <div class="invalid-feedback mb-1">
                                No hay stock suficiente!
                            </div>
                            <div class="valid-feedback">
                                Correcto!
                            </div>
                        </div>
                        <input class="btn btn-success me-2" type="submit" name="boton_enviar" id="boton_enviar" value="Agregar al Carrito">
                        <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cerrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title text-white" id="exampleModalToggleLabel">Carrito</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div>
                        <?php
                        if ($objSession->activa()) {
                            $objUsuario = $objSession->getUsuario();
                            if ($objUsuario != null) {
                                $objCompra = new C_Compra();
                                $idUsuario["idUsuario"] = $objUsuario->getIdUsuario();
                                $arrayCompra = $objCompra->buscar($idUsuario);
                                if ($arrayCompra != null) {
                                    $objCompraEstado = new C_CompraEstado();
                                    $objCompraEstadoBorrador = $objCompraEstado->buscarCompraBorrador($arrayCompra);
                                    if ($objCompraEstadoBorrador != null) {
                                        $objCompraItem = new C_CompraItem();
                                        $idCompra["idCompra"] = $objCompraEstadoBorrador->getCompra()->getIdCompra();
                                        $arrayCompraItem = $objCompraItem->buscar($idCompra);
                        ?>
                                        <table id="lista__carrito" class="table table-dark">
                                            <tr>
                                                <th>Imagen</th>
                                                <th>Nombre</th>
                                                <th>Descripcion</th>
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                                <th>Eliminar</th>
                                                <th class="d-none" id="idCompraEstado"><?php echo $objCompraEstadoBorrador->getIdCompraEstado() ?></th>
                                            </tr>
                                            <?php
                                            if ($arrayCompraItem != null) {
                                                foreach ($arrayCompraItem as $compraItem) {
                                                    echo '
                                                    <tr>
                                                        <td class="col-md-2"><img src="' . $compraItem->getObjProducto()->getUrlImagen() . '" class="img-thumbnail"></td>
                                                        <td>' . $compraItem->getObjProducto()->getNombre() . '</td>
                                                        <td>' . $compraItem->getObjProducto()->getDetalle() . '</td>
                                                        <td>' . $compraItem->getObjProducto()->getProPrecio() . '</td>
                                                        <td>' . $compraItem->getCantidad() . '</td>
                                                        <td class="d-none">' . $compraItem->getIdCompraItem() . '</td>
                                                        <td><a href="#" class="eliminar_producto_carrito"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash3 text-white" viewBox="0 0 16 16">
                                                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                                                </svg></a></td>
                                                    </tr>
                                                ';
                                                }
                                            }
                                            ?>
                                        </table>

                        <?php
                                    }
                                } else {
                                    echo "<h2 class='text-warning text-center'> No tiene ningun producto agregado al carrito!</h2>";
                                }
                            }
                        } else {
                            echo "<h2 class='text-warning text-center'> Debes crear una sesion para poder comprar productos! </h2>";
                        }
                        ?>
                    </div>
                    <span id="total-Compra"></span>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success me-2" id="iniciar_compra">Comprar</button>
                    <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container d-flex align-items-center justify-content-center">
        <div id="content__filter" class="col-md-8 text-center">
            <input type="text" name="filtrador" id="filtrador" class="col-md-6" placeholder="Buscador" onkeyup="filtrar(this.value)">
        </div>
        <div id="content__carrito" class="row justify-content-end">
            <a class="link-light col-md-3" data-bs-toggle="modal" href="#exampleModalToggle2" role="button">
                <img id="logo_carrito" src="../img/carritoCompra.png" class="img-fluid" alt="Logo de Carrito">
            </a>
        </div>
    </div>
    <div id="content__productos" class="text-center">
        <?php
        $objProducto = new C_Producto;
        $arrayProdcutos = $objProducto->buscar();
        if ($arrayProdcutos != null) {
            foreach ($arrayProdcutos as $producto) {
                echo '
            <div class="tarjetas-productos" onclick="verDetalle(this)">
                <a class="link-light" data-bs-toggle="modal" href="#exampleModalToggle1" role="button">
                    <div class="tarjeta-producto__imagen">
                        <img class="foto__producto" src="' . $producto->getUrlImagen() . '" alt="">
                    </div>
                    <div class="tarjeta-producto__info">
                        <p class="nombre__producto">' . $producto->getNombre() . '</p>
                        <span class="descripcion__producto d-none">' . $producto->getDetalle() . '</span>
                        <span class="precio__producto d-none">' . $producto->getProPrecio() . '</span>
                        <span class="stock d-none">' . $producto->getCantStock() . '</span>
                        <span class="idProducto_Producto d-none">' . $producto->getIdProducto() . '</span>
                    </div>
                </a>
            </div>
        ';
            }
        } else {
            echo "<h2 class='text-warning text-center'> No se encuentran productos cargados!</h2>";
        }
        ?>
    </div>
</div>
<script src="js/producto.js"></script>
<script src="js/mainIniciarCompraCarrito.js"></script>
<script src="js/mainAgregarProductoCarrito.js"></script>
<script src="js/mainBorrarProductoCarrito.js"></script>
<?php
    }else{
        header('Location: ../paginas/home.php');
    }
}else{
    header('Location: ../paginas/home.php');
}
include_once("../estructura/Pie.php")
?>