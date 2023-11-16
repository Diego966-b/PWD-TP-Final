<?php
class CompraEstadoTipo
{
    // Atributos

    private $idCompraEstadoTipo, $cetDescripcion, $cetDetalle, $mensajeOperacion;

    // Constructor y setear()

    public function __construct()
    {
        $this -> idCompraEstadoTipo = "";
        $this -> cetDescripcion = "";
        $this -> cetDetalle = "";
    }

    public function setear ($idCompraEstadoTipo, $cetDescripcion, $cetDetalle)
    {
        $this -> setIdCompraEstadoTipo($idCompraEstadoTipo);
        $this -> setCetDescripcion($cetDescripcion);
        $this -> setCetDetalle($cetDetalle);
    }

    // Gets

    public function getIdCompraEstadoTipo() { return $this->idCompraEstadoTipo; }
    public function getCetDescripcion() { return $this->cetDescripcion; }
    public function getCetDetalle() { return $this->cetDetalle; }
    public function getMensajeOperacion() { return $this->mensajeOperacion; }

    // Sets

    public function setIdCompraEstadoTipo($idCompraEstadoTipoNuevo) { $this->idCompraEstadoTipo = $idCompraEstadoTipoNuevo; }
    public function setCetDescripcion($cetDescripcionNuevo) { $this->cetDescripcion = $cetDescripcionNuevo; }
    public function setCetDetalle($cetDetalleNuevo) { $this->cetDetalle = $cetDetalleNuevo; }
    public function setMensajeOperacion($mensajeOperacionNuevo) { $this->mensajeOperacion = $mensajeOperacionNuevo; }

    // Metodos

    public function cargar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = 
        "SELECT * FROM compraEstadoTipo WHERE idCompraEstadoTipo = " . $this->getIdCompraEstadoTipo();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $idCompraEstadoTipo = $row ['idCompraEstadoTipo'];
                    $cetDescripcion = $row ['cetDescripcion'];
                    $cetDetalle = $row ['cetDetalle'];
                    $this->setear($idCompraEstadoTipo, $cetDescripcion, $cetDetalle);
                }
            }
        } else {
            $this->setMensajeOperacion("compraEstadoTipo->listar: " . $base->getError());
        }
        return $respuesta;
    }

    public function insertar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = 
        "INSERT INTO compraEstadoTipo (idCompraEstadoTipo, cetDescripcion, cetDetalle)
            VALUES ('" . 
            $this->getIdCompraEstadoTipo() . "', '" . 
            $this->getCetDescripcion() . "', '" . 
            $this->getCetDetalle() . "')";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("compraEstadoTipo->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraEstadoTipo->modificar: " . $base->getError());
        }
        return $respuesta;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = 
        "UPDATE compraEstadoTipo SET 
            cetDescripcion='" . $this->getCetDescripcion() . "',
            cetDetalle='" . $this->getCetDetalle() . "'
        WHERE idCompraEstadoTipo='" . $this->getIdCompraEstadoTipo() . "'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("compraEstadoTipo->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("compraEstadoTipo->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compraEstadoTipo WHERE idCompraEstadoTipo = " . $this->getIdCompraEstadoTipo();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("compraEstadoTipo->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraEstadoTipo->eliminar: " . $base->getError());
        }
        return $respuesta;
    }

    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos;
        $sql = "SELECT * FROM compraEstadoTipo ";
        if ($parametro != "") {
            $sql .= "WHERE " . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new CompraEstadoTipo();
                    $idCompraEstadoTipo = $row ['idCompraEstadoTipo'];
                    $cetDescripcion = $row ['cetDescripcion'];
                    $cetDetalle = $row ['cetDetalle'];
                    $obj->setear($idCompraEstadoTipo, $cetDescripcion, $cetDetalle);
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
        $frase =
            "<br>El idCompraEstadoTipo es: " . $this->getIdCompraEstadoTipo() .
            "<br>El cetDescripcion es: " . $this->getCetDescripcion() .
            "<br>El cetDetalle es: " . $this-> getCetDetalle() ."<br>";
        return $frase;
    }
}
?>