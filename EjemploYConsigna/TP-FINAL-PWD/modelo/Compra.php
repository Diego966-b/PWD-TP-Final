<?php
class Compra
{
    private $idCompra;
    private $fecha;
    private $objUsuario;


    /**************************************/
    /**************** SET *****************/
    /**************************************/

    /**
     * Establece el valor de idCompra
     */
    public function setIdCompra($idCompra)
    {
        $this->idCompra = $idCompra;
    }

    /**
     * Establece el valor de fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * Establece el valor de objUsuario
     */
    public function setObjUsuario($objUsuario)
    {
        $this->objUsuario = $objUsuario;
    }

    /**
     * Establece el valor de mensajeFuncion
     */
    public function setMensajeFuncion($mensajeFuncion)
    {
        $this->mensajeFuncion = $mensajeFuncion;
    }

    /**************************************/
    /**************** GET *****************/
    /**************************************/

    /**
     * Obtiene el valor de idCompra
     */
    public function getIdCompra()
    {
        return $this->idCompra;
    }

    /**
     * Obtiene el valor de fecha
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Obtiene el valor de objUsuario
     */
    public function getObjUsuario()
    {
        return $this->objUsuario;
    }

    /**
     * Obtiene el valor de mensajeFuncion
     */
    public function getMensajeFuncion()
    {
        return $this->mensajeFuncion;
    }

    /**************************************/
    /************** FUNCIONES *************/
    /**************************************/

    public function __construct()
    {
        $this->idCompra = "";
        $this->fecha = "";
        $this->objUsuario = new Usuario;
    }

    public function setear($idCompra, $fecha, $idUsuario)
    {
        $resp = false;
        $this->objUsuario->setIdUsuario($idUsuario);
        if ($this->objUsuario->cargar()) {
            $this->setIdCompra($idCompra);
            $this->setFecha($fecha);
            $resp = true;
        }
        return $resp;
    }

    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $consulta = "INSERT INTO compra (coFecha, idUsuario) VALUES (
		'" . $this->getFecha() . "',
		" . $this->getObjUsuario()->getIdUsuario(). ")";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $resp =  true;
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $consulta = "UPDATE compra
        SET idCompra = {$this->getIdCompra()},
        coFecha = '{$this->getFecha()}',
        idUsuario = {$this->getObjUsuario()->getIdUsuario()},
        WHERE idCompra = {$this->getIdCompra()}";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $resp =  true;
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $resp;
    }

    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = null;
        if($this->getIdCompra()!=''){
            $sql = "SELECT * FROM compra WHERE idCompra = " . $this->getIdCompra();
        }
        //echo $sql;
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['idCompra'], $row['coFecha'], $row['idUsuario']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $resp;
    }
    
    public function listar($condicion = "")
    {
        $arregloCompra = null;
        $base = new BaseDatos();
        $consultaCompra = "SELECT * FROM compra ";
        if ($condicion != "") {
            $consultaCompra = $consultaCompra . ' WHERE ' . $condicion;
        }
        $consultaCompra .= " ORDER BY idCompra ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaCompra)) {
                $arregloCompra = array();
                while ($compra = $base->Registro()) {
                    $objcompra = new Compra();
                    $objcompra->setear($compra['idCompra'], $compra['coFecha'], $compra['idUsuario']);
                    array_push($arregloCompra, $objcompra);
                }
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $arregloCompra;
    }

    public function eliminar()
    {
        $base = new BaseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consulta = "DELETE FROM compra WHERE idCompraItem = '" . $this->getIdCompra() . "'";
            if ($base->Ejecutar($consulta)) {
                $resp =  true;
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $resp;
    }
}
