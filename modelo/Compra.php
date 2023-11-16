<?php
class Compra 
{
    // Atributos

    private $idCompra, $coFecha, $objUsuario, $mensajeOperacion;
    
    // Constructor y setear
    
    public function __construct()
    {
        $this -> idCompra = "";
        $this -> coFecha = "";
        $this -> objUsuario = new Usuario();
    }

    public function setear($idCompra, $coFecha, $objUsuario)
    {
        $this -> setIdCompra($idCompra);
        $this -> setCoFecha($coFecha);
        $this -> setObjUsuario($objUsuario);
    }
    
    // Gets

    public function getIdCompra() { return $this->idCompra; }
    public function getCoFecha() { return $this->coFecha; }
    public function getObjUsuario() { return $this->objUsuario; }
    public function getMensajeOperacion() { return $this->mensajeOperacion; }

    // Sets

    public function setIdCompra($idCompraNuevo) { $this->idCompra = $idCompraNuevo; }
    public function setCoFecha($coFechaNuevo) { $this->coFecha = $coFechaNuevo; }
    public function setObjUsuario($objUsuarioNuevo) { $this->objUsuario = $objUsuarioNuevo; }
    public function setMensajeOperacion($mensajeOperacionNuevo) { $this->mensajeOperacion = $mensajeOperacionNuevo; }

    // Metodos

    public function cargar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = 
        "SELECT * FROM compra WHERE idCompra = " . $this->getIdCompra();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $abmUsuario = new AbmUsuario();
                    $array = [];
                    $array ['idUsuario'] = $row['idUsuario'];
                    $listaUsuarios = $abmUsuario -> buscar ($array);
                    $objUsuario = $listaUsuarios[0];
                    $idCompra = $row['idCompra'];
                    $coFecha = $row['coFecha'];
                    $this -> setear($idCompra, $coFecha, $objUsuario);
                }
            }
        } else {
            $this->setMensajeOperacion("compra->listar: " . $base->getError());
        }
        return $respuesta;
    }

    public function insertar()
    {
        $respuesta = false;
        $ultimoId = null;
        $base = new BaseDatos();
        $objUsuario = $this->getObjUsuario();
        $sql = 
        "INSERT INTO compra (coFecha, idUsuario)
            VALUES ('" 
            .$this->getCoFecha() . "', '" . 
            $objUsuario->getIdUsuario() . "')";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $respuesta = true;
                $ultimoId = $base -> devolverUltimoId("idCompra");
            } else {
                $this->setMensajeOperacion("compra->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compra->modificar: " . $base->getError());
        }
        return $ultimoId;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $objUsuario = $this->getObjUsuario();
        $sql = 
        "UPDATE compra SET 
            coFecha='" . $this->getCoFecha() . "',
            idUsuario='" . $objUsuario->getIdUsuario() . "',
        WHERE idCompra='" . $this->getIdCompra() . "'";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("compra->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("compra->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compra WHERE idCompra = " . $this->getIdCompra();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("compra->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compra->eliminar: " . $base->getError());
        }
        return $respuesta;
    }

    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos;
        $sql = "SELECT * FROM compra ";
        if ($parametro != "") {
            $sql .= "WHERE " . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $abmUsuario = new AbmUsuario();
                    $obj = new Compra();
                    $array = [];
                    $array ['idUsuario'] = $row['idUsuario'];
                    $listaUsuarios = $abmUsuario -> buscar ($array);
                    $objUsuario = $listaUsuarios[0];
                    $idCompra = $row['idCompra'];
                    $coFecha = $row['coFecha'];
                    $obj -> setear($idCompra, $coFecha, $objUsuario);
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
        $objUsuario = $this -> getObjUsuario();
        $frase =
            "<br>El id de la compra es: " . $this->getIdCompra() .
            "<br>El coFecha es: " . $this->getCoFecha() .
            "<br>El id del usuario es: " . $objUsuario -> getIdUsuario() ."<br>";
        return $frase;
    }
}
