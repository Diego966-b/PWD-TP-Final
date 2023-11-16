<?php
    include_once('../../../config.php');
    //  include_once($ESTRUCTURA . "/header.php"); 

    $data = data_submitted();
    $objAbmCompraItem= new AbmCompraItem();
    $data['accion']='borrar';
    // $listaObjCompraItem = $objAmbCompraItem->buscar($data);
    $idCompra=$data['idCompra'];
    $param['idCompraItem']=$data['idCompraItem'];
    $param['accion']='borrar';
    $objAbmCompraItem->abm($param);
  
    $param1['idCompra']=$idCompra;
    $listaObjCompraItem = $objAbmCompraItem->buscar($param1);
    $objAbmCompraEstado=new AbmCompraEstado();
    $objAbmCompra= new AbmCompra();
    if(count($listaObjCompraItem)==0){
        $listarCompraEstado = $objAbmCompraEstado->buscar(null);
        foreach ($listarCompraEstado as $compraEstado) {
            $idCompraActual = $compraEstado->getObjCompra()->getIdCompra();
            if ($idCompra == $idCompraActual) {
                $arrayBorrar = [];
                $arrayBorrar['idCompraEstado'] = $compraEstado->getIdCompraEstado();
                $arrayBorrar['accion'] = "borrar";
                $objAbmCompraEstado->abm($arrayBorrar);
            }
        }
        $arregloCompras = $objAbmCompra->buscar($data);
        $objCompra = $arregloCompras[0];
        $array['idCompra'] = $idCompra;
        $array['accion'] = "borrar";
        $respuesta = $objAbmCompra->abm($array);
    }
    if ($respuesta) {
        echo json_encode(array("success" => true));
    } else {
        echo "no anduvo";
    }
?>
