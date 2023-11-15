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
            <!--  <th scope="col">Productos Compra</th> Imagen, nombre, cantidad comprada--->
            <!--   <th scope="col">Total por producto</th> Imagen, nombre, cantidad comprada--->
            <th scope="col">IdCompra</th> <!--IdCOmpra--->
            <th scope="col">Fecha de la compra</th>
            <th scope="col">Nombre del usuario</th>
            <th scope="col">Estados de la compra</th> <!--Muestra el estado, iniciada/cancelada/finalizada/etc--->
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
            // echo '<td>';
            foreach ($listadoProducto as $producto) {


                foreach ($listadoCompraItem as $item) {
                    if ($item->getObjCompra()->getIdCompra() == $compra->getIdCompra()) {
                        if ($item->getObjProducto()->getIdProducto() == $producto->getIdProducto()) {
                            //  echo  $item->getObjProducto()->getProNombre() . "$" . $item->getObjProducto()->getProPrecio(). " x ".$item->getCiCantidad(). "<br>";
                            //$total = $item->getObjProducto()->getProPrecio() * $item->getCiCantidad();
                            array_push($arrayTotal,  $total);
                            // echo "$" . $item->getObjProducto()->getProPrecio() * $item->getCiCantidad() ;                            
                        }
                    }
                }
            }

            // echo '<td>' ;
            /*
            foreach($arrayTotal as $precio){
                echo $precio . "<br>";
            }
            */
            echo '</td>';
            echo '</td>';
            echo '<td>' .  $compra->getIdCompra() . '</td>';
            echo '<td>' . $compra->getCoFecha() . '</td>';
            echo '<td>' . $compra->getObjUsuario()->getUsNombre() . '</td>';
            echo '<td>';

            foreach ($listarCompraEstado as $estado) {
                if ($estado->getObjCompra()->getIdCompra() == $compra->getIdCompra()) {
                    echo  "Estado: " . $estado->getObjCompraEstadoTipo()->getCetDescripcion() . '<br>';
                    echo   "Fecha Inicio estado: " . $estado->getceFechaIni() . '<br>';
                    echo  "Fecha fin de estado: " . $estado->getceFechaFin() . '<br>';
                }
            }

            echo '</td>';

            echo '<td>' .
                '<form id="formSelect">' .
                '<select name="estado" id="estado-'.$compra->getIdCompra().'">';
            foreach ($listadoCompraEstadoTipo as $estadoTipo) {
                echo '<option value=" ' . $estadoTipo->getIdCompraEstadoTipo() . '"> ' . $estadoTipo->getCetDescripcion() . '</option>';
            }

           echo '</select>';
       //echo '<button type="button" class="btn btn-primary" onclick="enviarDatos('.$compra->getIdCompra().'\', \',' . $estadoTipo->getIdCompraEstadoTipo() .')">Guardar</button>';
       echo '<button type="button" class="btn btn-primary" onclick="enviarDatos('.$compra->getIdCompra().')">Guardar</button>';
       echo '</form>';

            echo '</td>';
        }



        //codigo va aca

    
        ?>
        
        </tr>

    </tbody>
</table>
<div id="resultado"></div>

<script>
    function enviarDatos(idCompra) {
        console.log("entro");
        var idCompraEstadoTipo = $("#estado-"+idCompra).val();
        console.log(idCompraEstadoTipo);       
    
        $.ajax({
            type: "POST",
            url: "actualizarEstado.php",
            data: {
                idCompraEstadoTipo: idCompraEstadoTipo,
                idCompra : idCompra,
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