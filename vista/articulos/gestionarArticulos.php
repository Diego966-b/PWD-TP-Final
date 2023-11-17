<?php
include_once("../../config.php");
$pagSeleccionada = "Gestionar Articulos";
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
            // agreegar para todas las paginas 
            $estadoPagina = $objSession->estadoMenu();
            if (!$estadoPagina) {
                header("Refresh: 0; URL='$VISTA/home/index.php'");
            }
        } else {
            header("Refresh: 0; URL='$VISTA/acceso/login.php'");
        }
    ?>
</head>

<body>
    <div id="filtro-opacidad">
     <div id="contenido-perfil">
            <br>
            <br>
            <div style="margin-bottom: 80px;">
                <div class="container text-center p-4 mt-3 cajaLista">
                    <h1>Gestion de Articulos</h1>
                    <div class="table-responsive">
                        <table class="table m-auto">
                            <thead class="table-dark fw-bold">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre Producto</th>
                                    <th scope="col">Detalle del Producto</th>
                                    <th scope="col">Imagen</th>
                                    <th scope="col">Stock</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Habilitado</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <?php
                                    $objControl = new AbmProducto();
                                    $list = $objControl->buscar(null);
                                    foreach ($list as $elem) {
                                        echo '<td>' . $elem->getIdProducto() . '</td>';
                                        echo '<td>' . $elem->getProNombre() . '</td>';
                                        echo '<td>' . $elem->getProDetalle() . '</td>';
                                        echo '<td>' . $elem->getProImagen() . '</td>';
                                        echo '<td>' . $elem->getProCantStock() . '</td>';
                                        echo '<td>' . $elem->getProPrecio() . '</td>';
                                        if ($elem->getProDeshabilitado() == null) {
                                            echo '<td> Activo </td>';
                                        } else {
                                            echo '<td>' . $elem->getProDeshabilitado() . '</td>';
                                        }
                                        //<button class="btn btn-danger" onclick="eliminarArticulo(' .  $elem->getIdProducto() . ')">Eliminar</button>
                                        echo '<td><button class="btn btn-primary mx-1 btn-modificar">Modificar</button>';

                                        if ($elem->getProDeshabilitado() == null) {
                                            echo '<button class="btn btn-danger mx-1" onclick="eliminarArticulo(' .  $elem->getIdProducto() . ')">Dar baja</button>';
                                            // echo '<a class="btn btn-danger mx-1" href="' . $VISTA . '/action/abmUsuarios.php?accion=borrar&idUsuario=' . $user->getIdUsuario() . '">Dar baja</a>';
                                        } else {
                                            echo '<button class="btn btn-success mx-1" onclick="altaArticulo(' .  $elem->getIdProducto() . ')">Dar de alta</button>';
                                            // echo '<a class="btn btn-success mx-1" href="' . $VISTA . '/action/abmUsuarios.php?accion=alta&idUsuario=' . $user->getIdUsuario() . '">Dar de alta</a>';
                                        }
                                        echo '</td>';
                                        echo '</tr>';
                                    } ?>
                            </tbody>
                        </table>

                    </div>

                     
                    <button type="button" class="btn btn-success my-2" id="abrirModal">
                        Agregar Producto
                    </button>
                    <!-- Modal -->

                    <div class="modal" id="miModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Cabecera del modal -->
                                <form id="miFormularioNuevo" name="miFormulario">
                                <div class="modal-header bg-dark text-ligth">
                                    <h4 class="modal-title">Cargar nuevo producto</h4>
                                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                                </div>
                                <!-- Cuerpo del modal con el formulario -->
                                <div class="modal-body text-black">
                                        <label for="proNombre">Nombre del Producto:</label>
                                        <input type="text" id="proNombre" name="proNombre" class="form-control" required>

                                        <label for="proDetalle">Descripcion del producto:</label>
                                        <input type="text" id="proDetalle" name="proDetalle" class="form-control" required>

                                        <label for="proImagen">Imagen del Producto:</label>
                                        <input type="text" id="proImagen" name="proImagen" class="form-control" required>

                                        <label for="proCantStock">Cantidad de stock:</label>
                                        <input type="number" id="proCantStock" name="proCantStock" class="form-control" required>

                                        <label for="proPrecio">Precio:</label>
                                        <input type="number" id="proPrecio" name="proPrecio" class="form-control" required>

                                    </div>
                                    <!-- Pie del modal -->
                                    <div class="modal-footer bg-dark">
                                        <input type="submit" value="Enviar" class="btn btn-success">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                 
                    <!-- Modal de Modificación -->

                    <div class="modal" id="modalModificar">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-dark text-ligth">
                                    <h4 class="modal-title">Modificar Producto</h4>
                                </div>
                                <div class="modal-body text-black">
                                    <form id="miFormularioModificar" name="miFormulario">
                                        <input type="number" id="proIdModificar" hidden>

                                        <label for="proNombreModificar">Nombre del Producto:</label>
                                        <input type="text" id="proNombreModificar" name="proNombreModificar" class="form-control" required>

                                        <label for="proDetalleModificar">Descripcion del producto:</label>
                                        <input type="text" id="proDetalleModificar" name="proDetalleModificar" class="form-control" required>

                                        <label for="proImagenModificar">Imagen del Producto:</label>
                                        <input type="text" id="proImagenModificar" name="proImagenModificar" class="form-control" required>

                                        <label for="proCantStockModificar">Cantidad de stock:</label>
                                        <input type="number" id="proCantStockModificar" name="proCantStockModificar" class="form-control" required>

                                        <label for="proPrecioModificar">Precio:</label>
                                        <input type="number" id="proPrecioModificar" name="proPrecioModificar" class="form-control" required>                                        
                                    </form>
                                </div>
                                <div class="modal-footer bg-dark">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-primary" onclick="guardarCambios()">Guardar Cambios</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include_once($ESTRUCTURA . "/pie.php"); ?>
                    <script src="./js/funcionesABMarticulo.js"></script>
                </div>
            </div>
        </div>
    </div>
</body>

</html>