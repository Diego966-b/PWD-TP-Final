<?php
class Carrito
{
    // Atributos

    public function __construct()
    {
        
    }

    /**
     * 
     * 
     */
    public function pagarCarrito ($colDatos, $objUsuario)
    {
        $abmProducto = new AbmProducto();
        $abmCompra = new AbmCompra();
        $abmCompraEstado = new AbmCompraEstado();
        $abmCompraEstadoTipo = new AbmCompraEstadoTipo();
        $abmCompraItem = new AbmCompraItem();
        $colProductosCarrito = [];
        $arrayConsulta = [];
        $carrito = $colDatos["carrito"];
    
        // Creo un nuevo Compra
    
        $arrayConsulta = [];
        $idUsuario = $objUsuario -> getIdUsuario();
        $arrayConsulta ["idUsuario"] = $idUsuario;
        $arrayConsulta ["coFecha"] = date("Y-m-d H:i:s");
        $arrayConsulta ["accion"] = "nuevo";
        $resultado = $abmCompra -> abm($arrayConsulta);
    
        $exito = $resultado["exito"];
        if ($exito)
        {
            // Buscar idCompra y guardarlo
            $idCompra = $resultado ["id"]; 
        }
    
        // Creo un nuevo CompraEstado
    
        $arrayConsulta = [];
        $arrayConsulta ["accion"] = "nuevo";
        $arrayConsulta ["idCompraEstadoTipo"] = 1; // guardo 1 ya que es el id de la compra iniciada
        $arrayConsulta ["ceFechaIni"] = date("Y-m-d H:i:s");
        $arrayConsulta ["ceFechaFin"] = "0000-00-00 00:00:00";
        $arrayConsulta ["idCompra"] = $idCompra; 
        $resultado = $abmCompraEstado -> abm($arrayConsulta);
    
        // Creo el CompraItem
    
        for ($i = 0; $i < count($carrito); $i++)
        {
            $arrayBusqueda = [];
            $arrayConsulta = [];
            $arrayProducto = $carrito [$i];
            $idProducto = $arrayProducto ["idProducto"];
            $proCantidad = $arrayProducto ["proCantidad"];
            /*
            $arrayBusqueda ["idProducto"] = $idProducto;
            $objProducto = $abmProducto -> buscar($arrayBusqueda);
            $objProducto = $objProducto [0];
            */
            // compraItem
            $arrayConsulta ["accion"] = "nuevo";
            $arrayConsulta ["ciCantidad"] = $proCantidad;
            $arrayConsulta ["idProducto"] = $idProducto;
            $arrayConsulta ["idCompra"] = $idCompra; 
            $abmCompraItem -> abm($arrayConsulta);
            //array_push($colProductosCarrito, $objProducto);
        }
    }

}

?>