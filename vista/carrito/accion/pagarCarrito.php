<?php
    include_once("../../../config.php");
    include_once($ESTRUCTURA."/header.php");
    include_once($ESTRUCTURA."/cabeceraBD.php");
    $colDatos = data_submitted();
    /*
    $carrito = new Carrito();
    $objUsuario = $objSession->getObjUsuario();
    $carrito -> pagarCarrito ($colDatos, $objUsuario);
    */
    
    $abmProducto = new AbmProducto();
    $abmCompra = new AbmCompra();
    $abmCompraEstado = new AbmCompraEstado();
    $abmCompraEstadoTipo = new AbmCompraEstadoTipo();
    $abmCompraItem = new AbmCompraItem();
    $colProductosCarrito = [];
    $arrayConsulta = [];
    $carrito = $colDatos["carrito"];
    $objUsuario = $objSession -> getUsuario();

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
        $idCompraABAC = $resultado ["id"]; 
    }
    else
    {
        $idCompraABAC = "";
    }

    // Creo un nuevo CompraEstado

    $arrayConsultaCE = [];
    $arrayConsultaCE ["accion"] = "nuevo";
    $arrayConsultaCE ["idCompraEstadoTipo"] = 1; // guardo 1 ya que es el id de la compra iniciada
    $arrayConsultaCE ["ceFechaIni"] = date("Y-m-d H:i:s");
    $arrayConsultaCE ["ceFechaFin"] = "0000-00-00 00:00:00";
    $arrayConsultaCE ["idCompra"] = $idCompraABAC; 
    $resultado = $abmCompraEstado -> abm($arrayConsultaCE);

    // Creo el CompraItem

    for ($i = 0; $i < count($carrito); $i++)
    {
        $arrayBusqueda = [];
        $arrayConsulta = [];
        $arrayProducto = $carrito [$i];
        $idProducto = $arrayProducto ["idProducto"];
        $proCantidad = $arrayProducto ["proCantidad"];
        
        //$arrayBusqueda ["idProducto"] = $idProducto;
        //$objProducto = $abmProducto -> buscar($arrayBusqueda);
        //$objProducto = $objProducto [0];
        
        // compraItem
        $arrayConsulta ["accion"] = "nuevo";
        $arrayConsulta ["ciCantidad"] = $proCantidad;
        $arrayConsulta ["idProducto"] = $idProducto;
        $arrayConsulta ["idCompra"] = $idCompraABAC; 
        $abmCompraItem -> abm($arrayConsulta);
        //array_push($colProductosCarrito, $objProducto);
    }
    
    //$objSession -> eliminarCarrito();
    
?>