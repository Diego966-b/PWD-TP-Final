<?php
include_once 'conector/BaseDatos.php';

class CompraEstado{
    private $idCompraEstado;
    private $compra;
    private $compraEstadoTipo;
    private $ceFechaIni;
    private $ceFechaFin;
    private $mensajeOperacion;

    public function __construct(){
        $this->idCompraEstado = "";
        $this->compra = new Compra();
        $this->comoEstadoTipo = new CompraEstadoTipo();
        $this->ceFechaIni = null;
        $this->ceFechaFin = null;
    }

    public function setear($id, $compra, $compraEstadoTipo, $ceFechaIni, $ceFechaFin){
        $this->setIdCompraEstado($id);
        $this->setCompra($compra);
        $this->setCompraEstadoTipo($compraEstadoTipo);
        $this->setCeFechaIni($ceFechaIni);
        $this->setCeFechaFin($ceFechaFin);
    }

    public function getIdCompraEstado(){
        return $this->idCompraEstado;
    }
    public function setIdCompraEstado($idCompraEstado){
        $this->idCompraEstado = $idCompraEstado;
    }
    
    public function getCeFechaIni(){
        return $this->ceFechaIni;
    }
    public function setCeFechaIni($ceFechaIni){
        $this->ceFechaIni = $ceFechaIni;
    }
    
    public function getCeFechaFin(){
        return $this->ceFechaFin;
    } 
    public function setCeFechaFin($ceFechaFin){
        $this->ceFechaFin = $ceFechaFin;
    }

    public function getCompra(){
        return $this->compra;
    }
    public function setCompra($compra){
        $this->compra = $compra;
    }

    public function getCompraEstadoTipo(){
        return $this->compraEstadoTipo;
    }
    public function setCompraEstadoTipo($compraEstadoTipo){
        $this->compraEstadoTipo = $compraEstadoTipo;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraestado WHERE idCompraEstado = " .$this->getIdCompraEstado();
        
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            
            if ($res > -1) {
                if ($res > 0){
                    $row = $base->Registro();
                    
                    $compra = null;
                    if ($row['idCompra'] != null) {
                        $compra = new Compra();
                        $compra->setIdCompra($row['idCompra']);
                        $compra->cargar();
                    }

                    $compraEstadoTipo = null;
                    if ($row['idCompraEstadoTipo'] != null) {
                        $compraEstadoTipo = new CompraEstadoTipo();
                        $compraEstadoTipo->setIdCompraEstadoTipo($row['idCompraEstadoTipo']);
                        $compraEstadoTipo->cargar();
                    }
                
                    $resp =  true;
                    $this->setear($row['idCompraEstado'],$compra,$compraEstadoTipo,$row['ceFechaIni'],$row['ceFechaFin']);
                }
            }
        } else {
            $this->setMensajeOperacion("menu->listar: " . $base->getError());
        }
        return $resp;
    }

    public function insertar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO compraestado (idCompra,idCompraEstadoTipo,ceFechaIni,ceFechaFin)  VALUES (
                ".$this->getCompra()->getIdCompra().",
                ".$this->getCompraEstadoTipo()->getIdCompraEstadoTipo().",
                '".$this->getCeFechaIni()."',
                '".$this->getCeFechaFin()."'
                )";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraestado->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraestado->insertar: " . $base->getError());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compraestado SET 
                idCompraEstado=".$this->getIdCompraEstado().", 
                idCompra=".$this->getCompra()->getIdCompra().", 
                idCompraEstadoTipo=".$this->getCompraEstadoTipo()->getIdCompraEstadoTipo().", 
                ceFechaFin='".$this->getCeFechaFin()."', 
                ceFechaIni='".$this->getCeFechaIni()."'
                WHERE idCompraEstado=".$this->getIdCompraEstado();
        
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("CompraEstado->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("CompraEstado->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compraEstado WHERE idCompraEstado=" . $this->getIdCompraEstado();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("CompraEstado->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("CompraEstado->eliminar: " . $base->getError());
        }
        return $resp;
    }
    
    public function listar($parametro = ""){
        $arreglo = null;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraEstado ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {

                $arreglo = array();
                while ($row = $base->Registro()) {
                    $obj = new CompraEstado();

                    $objCompra = null;
                    if ($row['idCompra'] != null) {
                        $objCompra = new Compra();
                        $objCompra->setIdCompra($row['idCompra']);
                        $objCompra->cargar();
                    }
                    $objCompraEstadoTipo = null;
                    if ($row['idCompraEstadoTipo'] != null) {
                        $objCompraEstadoTipo = new CompraEstadoTipo();
                        $objCompraEstadoTipo->setIdCompraEstadoTipo($row['idCompraEstadoTipo']);
                        $objCompraEstadoTipo->cargar();
                    }

                    $obj->setear($row['idCompraEstado'], $objCompra, $objCompraEstadoTipo, $row['ceFechaIni'], $row['ceFechaFin']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeOperacion("CompraEstado->listar: " . $base->getError());
        }
        return $arreglo;
    }
}
?>