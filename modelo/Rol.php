<?php
class Rol {

    // Atributos

    private $idRol, $rolDescripcion, $mensajeoperacion,$rolDeshabilitado;

    // Constructor y setear

    public function __construct()
    {
        $this->idRol = "";
        $this->rolDescripcion = "";
        $this->rolDeshabilitado = "";
        $this->mensajeoperacion = "";
    }

    public function setear($idRol, $rolDescripcion,$rolDeshabilitado){
        $this->setIdRol($idRol);
        $this->setRolDescripcion($rolDescripcion);
        $this->setRolDeshabilitado($rolDeshabilitado);
    }

    // Sets

    public function setIdRol($idRol){ $this->idRol = $idRol; }
    public function setRolDescripcion($rolDescripcion){ $this->rolDescripcion = $rolDescripcion; }
    public function setRolDeshabilitado($rolDeshabilitado){$this->rolDeshabilitado= $rolDeshabilitado;}
    public function setMensajeOperacion($mensaje){ $this->mensajeoperacion = $mensaje; }

    // Gets

    public function getIdRol(){ return $this->idRol; }
    public function getRolDescripcion(){ return $this->rolDescripcion; }
    public function getMensajeOperacion(){ return $this->mensajeoperacion; }
    public function getRolDeshabilitado(){return $this->rolDeshabilitado;}


    // Métodos

    public function cargar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = 
        "SELECT * FROM rol WHERE idRol = " . $this->getIdRol();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['idRol'], $row['rolDescripcion'],$row['rolDeshabilitado']);
                }
            }
        } else {
            $this->setMensajeOperacion("Rol->listar: " . $base->getError());
        }
        return $respuesta;
    }

    public function insertar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO rol (rolDescripcion)
            VALUES ('".$this->getRolDescripcion() ."')";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("Rol->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Rol->modificar: " . $base->getError());
        }
        return $respuesta;
    }

    public function modificar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = 
        "UPDATE rol SET 
            rolDescripcion='" . $this->getRolDescripcion() . "' 
        WHERE idRol='" . $this->getIdRol() . "'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("Rol->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Rol->modificar: " . $base->getError());
        }
        return $respuesta;
    }

    public function eliminar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = 
        "DELETE FROM rol WHERE idRol=" . $this->getIdRol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("Rol->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Rol->eliminar: " . $base->getError());
        }
        return $respuesta;
    }
    public function eliminarLogico()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = 
        "UPDATE rol SET rolDeshabilitado= NOW() WHERE idRol=" . $this->getIdRol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("Rol->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Rol->eliminar: " . $base->getError());
        }
        return $respuesta;
    }
    public function altaLogica(){
        $respuesta = false;
        $base = new BaseDatos();
        $sql = 
        "UPDATE rol SET rolDeshabilitado= NULL WHERE idRol=" . $this->getIdRol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("Rol->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Rol->eliminar: " . $base->getError());
        }
        return $respuesta;
    }

    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos;
        $sql = "SELECT * FROM rol ";
        if ($parametro != "") {
            $sql .= "WHERE " . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new Rol();
                    $obj->setear($row['idRol'], $row['rolDescripcion'], $row["rolDeshabilitado"]);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            //$this->setMensajeoperacion("Rol->listar: " . $base->getError());
        }
        return $arreglo;
    }

    public function __toString()
    {
        $frase =
            "<br>El Id del Rol es: " . $this->getIdRol() .
            ".<br>La descripcion es: " . $this->getRolDescripcion()."<br>".
            ".<br>Estado es: " . $this->getRolDeshabilitado()."<br>";
        return $frase;
    }
}
?>