<?php
include_once("../../config.php");
$pagSeleccionada = "Deposito";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once($ESTRUCTURA . "/header.php"); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $CSS ?>/estilos.css">
    <!-- <a href="../pagSegura/pagSegura.php">PagSegura</a>-->
    <?php include_once($ESTRUCTURA . "/cabeceraBD.php"); ?>
    
</head>

<body>
    <h1>Gestion de Articulos</h1>

    <button type="button" class="btn btn-primary" id="abrirModal">
        Agregar Producto
    </button>

    <table class="table table-dark">
        <thead>
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
                    if($elem->getProDeshabilitado()== null){
                        echo '<td> Activo </td>';
                    }  else{
                        echo '<td>' . $elem->getProDeshabilitado() . '</td>';
                    }                      
                    //<button class="btn btn-danger" onclick="eliminarArticulo(' .  $elem->getIdProducto() . ')">Eliminar</button>
                    echo '<td><button class="btn btn-primary mx-1" id="modificar">Modificar</button>';
                   
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




    <!-- Modal -->
    <div class="modal" id="miModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Cabecera del modal -->
                <div class="modal-header">
                    <h4 class="modal-title">Cargar nuevo producto</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Cuerpo del modal con el formulario -->
                <div class="modal-body">
                    <form id="miFormulario">
                        <label for="nombre">Nombre del Producto:</label>
                        <input type="text" id="proNombre" name="proNombre" class="form-control" required>

                        <label for="proDetalle">Descripcion del producto:</label>
                        <input type="text" id="proDetalle" name="proDetalle" class="form-control" required>

                        <label for="proImagen">Imagen del Producto:</label>
                        <input type="text" id="proImagen" name="proImagen" class="form-control" required>

                        <label for="proCantStock">Cantidad de stock:</label>
                        <input type="number" id="proCantStock" name="proCantStock" class="form-control" required>

                        <label for="proPrecio">Precio:</label>
                        <input type="number" id="proPrecio" name="proPrecio" class="form-control" required>

                        <br>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                </div>

                <!-- Pie del modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Modificación -->

    <div class="modal" id="modalModificar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modificar Producto</h4>
                </div>

                <div class="modal-body">
                    <input type="number" id="proIdModificar" hidden>
                    <label for="nombre">Nombre del Producto:</label>
                    <input type="text" id="proNombreModificar" name="proNombre" class="form-control" required>

                    <label for="proDetalle">Descripcion del producto:</label>
                    <input type="text" id="proDetalleModificar" name="proDetalle" class="form-control" required>

                    <label for="imagen">Imagen del Producto:</label>
                    <input type="text" id="proImagenModificar" name="imagen" class="form-control" required>

                    <label for="proCantStock">Cantidad de stock:</label>
                    <input type="number" id="proCantStockModificar" name="proCantStock" class="form-control" required>

                    <br>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarCambios()">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>


    
    <?php include_once($ESTRUCTURA . "/pie.php"); ?>
    <script src="./js/funcionesABMarticulo.js"></script>
 
</body>

</html>