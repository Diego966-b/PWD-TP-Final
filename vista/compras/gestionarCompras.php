<?php
include_once("../../config.php");
$pagSeleccionada = "Productos";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once($ESTRUCTURA . "/header.php"); ?>
    <?php include_once($ESTRUCTURA . "/cabeceraBD.php"); ?>
</head>


<table class="table table-dark">
    <thead>
        <tr>
            <th scope="col">IdCompra</th> <!--IdCOmpra--->
            <th scope="col">Fecha de la compra</th>
            <th scope="col">Nombre del usuario</th>
            <th scope="col">Producto</th> <!--Imagen, nombre, cantidad comprada--->
            <th scope="col">Precio Total</th>
            <th scope="col">Estado de la compra</th> <!--Muestra el estado, iniciada/cancelada/finalizada/etc--->
            <th scope="col">fecha de finalizacion</th> <!--Muestra la fecha, en la que se termina la compra--->
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
        $listadoCompraTipo = $objCompraEstadoTipo->buscar(null);
        $listarCompraEstado = $objCompraEstado->buscar(null);
        $listadoCompraItem = $objCompraItem->buscar(null);

        echo '<tr>';
        foreach ($listadoCompra as $compra) {
            echo '<td>' . $compra->getIdCompra() . '</td>';
            echo '<td>' . $compra->getCoFecha() . '</td>';
            echo '<td>' . $compra->getObjUsuario()->getUsNombre() . '</td>';
            foreach ($listadoProducto as $producto) {
                if ($producto->getIdProducto() == 1) {
                    foreach($listadoCompraItem as $item){
                    echo '<td>' . $producto->getProNombre() . '<br>' . "$" . $producto->getProPrecio() . '</td>';
                    echo '<td>' . "$" . $producto->getProPrecio() * $item->getCiCantidad(). '</td>';
                }
                }
            }
        }

        foreach ($listarCompraEstado as $estado) {
            echo '<td>' . $estado->getObjCompraEstadoTipo()->getIdCompraEstadoTipo() . '</td>';
        }

        foreach ($listarCompraEstado as $compraEstado) {
            echo '<td>' .    $compraEstado->getceFechaFin() . '</td>';          
        }

        echo '<td>' .
            '<form id="formSelect">' .
            '</span><select name="estado" id="estado">';
        foreach ($listadoCompraTipo as $estado) {
            echo '<option value=" ' . $estado->getIdCompraEstadoTipo() . '"> ' . $estado->getCetDescripcion() . '</option>';
        }

        ?>
        </select>
        <button type="button" class="btn btn-primary" onclick="enviarDatos()">Guardar</button>
        </form>
        </td>
        </tr>

    </tbody>
</table>
<div id="resultado"></div>
<script src="./js/agregarItem.js"></script>
<script>
    function enviarDatos() {
        console.log("entro aca");
        var idCompraEstadoTipo = $("#estado").val();

        $.ajax({
            type: "POST",
            url: "actualizarEstado.php",
            data: {
                idCompraEstadoTipo: idCompraEstadoTipo
            },
            success: function(response) {
                $("#resultado").html(idCompraEstadoTipo);
            },
            error: function(error) {
                console.log("Error:", error);
            }
        });
    }
</script>
</body>

</html>