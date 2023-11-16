<?php
class CompraEstado
{
    // Atributos

    private $idCompraEstado, $objCompra, $objCompraEstadoTipo, $ceFechaIni, $ceFechaFin, $mensajeOperacion;

    // Constructor y setear()

    public function __construct()
    {
        $this -> idCompraEstado = "";
        $this -> objCompra = new Compra();
        $this -> objCompraEstadoTipo = new CompraEstadoTipo();
        $this -> ceFechaIni = "";
        $this -> ceFechaFin = "";
    }

    public function setear ($idCompraEstado, $objCompra, $objCompraEstadoTipo, $ceFechaIni, $ceFechaFin)
    {
        $this -> setIdCompraEstado ($idCompraEstado);
        $this -> setObjCompra ($objCompra);
        $this -> setObjCompraEstadoTipo($objCompraEstadoTipo);
        $this -> setCeFechaIni($ceFechaIni);
        $this -> setCeFechaFin($ceFechaFin);
    }

    // Get

    public function getIdCompraEstado() { return $this->idCompraEstado; }
    public function getObjCompra() { return $this->objCompra; }
    public function getObjCompraEstadoTipo() { return $this->objCompraEstadoTipo; }
    public function getCeFechaIni() { return $this->ceFechaIni; }
    public function getCeFechaFin() { return $this->ceFechaFin; }
    public function getMensajeOperacion() { return $this->mensajeOperacion; }

    // Set

    public function setIdCompraEstado($idCompraEstadoNuevo) { $this->idCompraEstado = $idCompraEstadoNuevo; }
    public function setObjCompra($objCompraNuevo) { $this->objCompra = $objCompraNuevo; }
    public function setObjCompraEstadoTipo($objCompraEstadoTipoNuevo) { $this->objCompraEstadoTipo = $objCompraEstadoTipoNuevo; }
    public function setCeFechaIni($ceFechaIniNuevo) { $this->ceFechaIni = $ceFechaIniNuevo; }
    public function setCeFechaFin($ceFechaFinNuevo) { $this->ceFechaFin = $ceFechaFinNuevo; }
    public function setMensajeOperacion($mensajeOperacionNuevo) { $this->mensajeOperacion = $mensajeOperacionNuevo; }

    // Metodos

    
    public function cargar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = 
        "SELECT * FROM compraEstado WHERE idCompraEstado = " . $this->getIdCompraEstado();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $abmCompra = new AbmCompra ();
                    $abmCompraEstadoTipo = new AbmCompraEstadoTipo ();
                    $arrayCompra = [];
                    $arrayCompraEstadoTipo = [];
                    $arrayCompra ['idCompra'] = $row['idCompra'];
                    $arrayCompraEstadoTipo ['idCompraEstadoTipo'] = $row['idCompraEstadoTipo'];
                    
                    $listaCompras = $abmCompra -> buscar($arrayCompra);
                    $listaCompraEstadoTipo = $abmCompraEstadoTipo -> buscar($arrayCompraEstadoTipo);
                    $objCompra = $listaCompras[0];
                    $objCompraEstadoTipo = $listaCompraEstadoTipo[0];
                    $idCompraEstado = $row ['idCompraEstado'];
                    $ceFechaIni = $row ['ceFechaIni'];
                    $ceFechaFin = $row ['ceFechaFin'];
                    $this->setear($idCompraEstado, $objCompra, $objCompraEstadoTipo, $ceFechaIni, $ceFechaFin);
                }
            }
        } else {
            $this->setMensajeOperacion("compraEstado->listar: " . $base->getError());
        }
        return $respuesta;
    }

    public function insertar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $objCompra = $this -> getObjCompra();
        $objCompraEstadoTipo = $this -> getObjCompraEstadoTipo();
        $sql = 
        "INSERT INTO compraEstado (ceFechaIni,ceFechaFin,idCompra, idCompraEstadoTipo) 
        VALUES ('"
         . $this->getCeFechaIni() . "', '" 
         . $this->getCeFechaFin() . "', '" 
         .$objCompra->getIdCompra() 
         . "', '" .$objCompraEstadoTipo->getIdCompraEstadoTipo() . "')";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("compraEstado->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraEstado->modificar: " . $base->getError());
        }
        return $respuesta;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $objCompra = $this -> getObjCompra();
        $objCompraEstadoTipo = $this -> getObjCompraEstadoTipo();
        $sql = 
        "UPDATE compraEstado SET 
            idCompra='" . $objCompra->getIdCompra() . "',
            idCompraEstadoTipo='" . $objCompraEstadoTipo->getIdCompraEstadoTipo() . "',
            ceFechaIni='" . $this->getCeFechaIni() . "',
            ceFechaFin='" . $this->getceFechaFin() . "'
        WHERE idCompraEstado='" . $this->getIdCompraEstado() . "'";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("compraEstado->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("compraEstado->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compraEstado WHERE idCompraEstado = " . $this->getIdCompraEstado();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("compraEstado->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraEstado->eliminar: " . $base->getError());
        }
        return $respuesta;
    }

    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos;
        $sql = "SELECT * FROM compraEstado ";
        if ($parametro != "") {
            $sql .= "WHERE " . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $abmCompra = new AbmCompra ();
                    $abmCompraEstadoTipo = new AbmCompraEstadoTipo ();
                    $obj = new CompraEstado ();
                    $array1 ['idCompra'] = $row['idCompra'];
                    $array2 ['idCompraEstadoTipo'] = $row['idCompraEstadoTipo'];
                    $listaCompras = $abmCompra -> buscar($array1);
                    $listaCompraEstadoTipo = $abmCompraEstadoTipo -> buscar($array2);
                    $objCompra = $listaCompras[0];
                    $objCompraEstadoTipo = $listaCompraEstadoTipo[0];
                    $idCompraEstado = $row ['idCompraEstado'];
                    $ceFechaIni = $row ['ceFechaIni'];
                    $ceFechaFin = $row ['ceFechaFin'];
                    $obj->setear($idCompraEstado, $objCompra, $objCompraEstadoTipo, $ceFechaIni, $ceFechaFin);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            //$this->setMensajeoperacion("usuarioRol->listar: " . $base->getError());
        }
        return $arreglo;
    }

    public function __toString()
    {
        $objCompra = $this -> getObjCompra();
        $objCompraEstadoTipo = $this -> getObjCompraEstadoTipo();
        $frase =
            "<br>El idCompraEstado es: " . $this->getIdCompraEstado() .
            "<br>El idCompra es: " . $objCompra->getIdCompra() .
            "<br>El cetDetalle es: " . $objCompraEstadoTipo-> getIdCompraEstadoTipo() ."<br>";
        return $frase;
    }
}
?>