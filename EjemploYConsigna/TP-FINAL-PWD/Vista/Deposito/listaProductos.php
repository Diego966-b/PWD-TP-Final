<?php
include_once("../estructura/Cabecera.php");
if($objSession->getVista()!=NULL){
    if ($objSession->getVista()->getIdRol() == 3) {
        $objProducto = new C_Producto();
        $arrayProductos = $objProducto->buscar();
?>

    <div class="container-fluid" style="margin-bottom: 19%">
        <div class="container col-md-10 text-white mt-5">
            <h2>Listado de productos existentes en la plataforma:</h2>
            <div class="mb-3">
                <div class="mt-3 mb-3">
                    <a class="btn text-decoration-none btn btn-outline-light" href="cargarProducto.php">AGREGAR PRODUCTO</a>
                </div>
                <?php
                if ($arrayProductos != null) {
                ?>

                    <table class="table table-striped table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Detalle</th>
                            <th>Cantidad de Stock</th>
                            <th>URL Imagen</th>
                            <th>Precio</th>
                            <th></th>
                            <th></th>
                        </tr>

                    <?php
                    foreach ($arrayProductos as $producto) {
                        echo '<tr>';
                        echo '<td>' . $producto->getIdProducto() . '</td>';
                        echo '<td>' . $producto->getNombre() . '</td>';
                        echo '<td>' . $producto->getDetalle() . '</td>';
                        echo '<td>' . $producto->getCantStock() . '</td>';
                        echo '<td>' . $producto->getUrlImagen() . '</td>';
                        echo '<td>' . $producto->getProPrecio() . '</td>';
                        echo '<td><a class="edit" href="#editarProducto"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                    </svg></a></td>';
                        echo '<td><a class="remove" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16"><path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/></svg></a></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<p class="lead">No hay productos registrados </p>';
                }
                    ?>
                    </table>
            </div>
        </div>


        <div class="container-fluid col-md-10 text-white mt-5 d-none" id='editarProducto'>
            <h2>Editar Producto:</h2>
            <div class="mb-3">

                <form id='form-editar' method="post" action="../Accion/accionActualizarProductos.php" class="needs-validation row text-white justify-content-center col-12" novalidate>
                    <table class="table table-striped table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Detalle</th>
                            <th>Cantidad de Stock</th>
                            <th>URL Imagen</th>
                            <th>Precio</th>
                        </tr>


                        <tr>
                            <td>
                                <div class="col-lg-7 col-12" id='mostrarId'></div>
                                <div class="col-lg-7 col-12 d-none"><input type="number" style="width: 40px;" name="idProducto" required></input></div>

                            <td>
                                <div class="col-lg-7 col-12 "><input type="text" style="width: 150px;" name="proNombre" required></input>
                                    <div class="invalid-feedback">
                                        Ingrese un nombre valido!</div>
                                    <div class="valid-feedback">
                                        Correcto!</div>
                                </div>
                            </td>

                            <td>
                                <div class="col-lg-7 col-12"><input type="text" style="width: 150px;" name="proDetalle" required></input>
                                    <div class="invalid-feedback">
                                        Por favor ingrese algún detalle.</div>
                                    <div class="valid-feedback">
                                        Correcto!</div>
                                </div>
                            </td>

                            <td>
                                <div class="col-lg-7 col-12"><input type="number" min="0" name="proCantStock" style="width: 100px;" required></input>
                                    <div class="invalid-feedback">
                                        Ingrese una cantidad válida!</div>
                                    <div class="valid-feedback">
                                        Correcto!</div>
                                </div>
                            </td>

                            <td>
                                <div class="col-lg-7 col-12"><input type="url" name="urlImagen" required></input>
                                    <div class="invalid-feedback">
                                        Ingrese una url!</div>
                                    <div class="valid-feedback">
                                        Correcto!</div>
                                </div>
                            </td>

                            <td>
                                <div class="col-lg-7 col-12 "><input type="number" style="width: 100px;" min="0" name="proPrecio" required></input>
                                    <div class="invalid-feedback">
                                        Ingrese un precio valido !</div>
                                    <div class="valid-feedback">
                                        Correcto!</div>
                                </div>
                            </td>
                        </tr>


                    </table>

                    <input class="btn btn-success mt-2 col-2" type="submit" name="boton_enviar" id="boton_enviar" value="MODIFICAR">
                    <input class="btn btn-danger mx-4 mt-2 col-2" name="boton_cancelar" type="button" id="boton_cancelar" value="CANCELAR">
                </form>
            </div>
        </div>
    </div>

    <script src="js/eliminarProducto.js"></script>
    <script src="js/editarProducto.js"></script>
<?php
    }else{
        header('Location: ../paginas/home.php');
    }
}else{
    header('Location: ../paginas/home.php');
}
include_once("../estructura/Pie.php");
?>