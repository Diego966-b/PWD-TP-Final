<?php
    include_once("../../config.php");
    include_once($ESTRUCTURA."/header.php");
    include_once($ESTRUCTURA."/cabeceraBD.php");
    $pagSeleccionada = "Carrito";
    /*
    $abmCompraEstado = new AbmCompraEstado();

    $arrayConsultaCE = [];
    $arrayConsultaCE ["accion"] = "nuevo";
    $arrayConsultaCE ["idCompraEstadoTipo"] = 1; // guardo 1 ya que es el id de la compra iniciada
    $arrayConsultaCE ["ceFechaIni"] = date("Y-m-d H:i:s");
    $arrayConsultaCE ["ceFechaFin"] = "0000-00-00 00:00:00";
    $arrayConsultaCE ["idCompra"] = 1; 
    $resultado = $abmCompraEstado -> abm($arrayConsultaCE);
    print_r($resultado);
    */
    /*
    $abmCompra = new AbmCompra();
    $arrayConsulta = [];
    $arrayConsulta ["idUsuario"] = 2;
    $arrayConsulta ["coFecha"] = date("Y-m-d H:i:s");
    $arrayConsulta ["accion"] = "nuevo";
    $resultado = $abmCompra -> abm($arrayConsulta);

    $exito = $resultado["exito"];
    print_r($resultado);
    if ($exito)
    {
        // Buscar idCompra y guardarlo
        $idCompra = $resultado ["id"]; 
        echo "ID DE INSERCION ES ".$idCompra;
    }
    else
    {
        echo "no exito";
    }
    */