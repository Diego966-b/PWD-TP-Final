<?php
include_once('conector/BaseDatos.php');

class Rol
{
    private $idRol;
    private $rolDescripcion;
    private $mensajeOperacion;

    /**************************************/
    /**************** SET *****************/
    /**************************************/

    public function setIdRol($idRol)
    {
        $this->idRol = $idRol;
    }

    public function setRolDescripcion($rolDescripcion)
    {
        $this->rolDescripcion = $rolDescripcion;
    }

    public function setMensajeOperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    /**************************************/
    /**************** GET *****************/
    /**************************************/

    public function getIdRol()
    {
        return $this->idRol;
    }

    public function getRolDescripcion()
    {
        return $this->rolDescripcion;
    }

    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    /**************************************/
    /************** FUNCIONES *************/
    /**************************************/

    public function __construct()
    {
        $this->idRol = "";
        $this->rolDescripcion = "";
    }


    public function setear($idRol, $rolDescripcion)
    {
        $this->setIdRol($idRol);
        $this->setRolDescripcion($rolDescripcion);
    }

    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM rol WHERE idRol = " . $this->getIdrol();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['idRol'], $row['rolDescripcion']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("rol->listar: " . $base->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO rol(idRol,rolDescripcion)  VALUES('" . $this->getIdrol() . "','" . $this->getRolDescripcion() . "');";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdRol($elid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("rol->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("rol->insertar: " . $base->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE rol SET rolDescripcion='" . $this->getRolDescripcion() . "'
        WHERE idRol=" . $this->getIdRol();
        if ($base->Iniciar()) {
            //var_dump($sql);
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("rol->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("rol->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM rol WHERE idRol=" . $this->getIdRol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("rol->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("rol->eliminar: " . $base->getError());
        }
        return $resp;
    }

    public static function listar($parametro = ""){
        $arreglo = [];
        $base = new BaseDatos();
        $sql = "SELECT * FROM rol ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new Rol();
                    $obj->setear($row['idRol'], $row['rolDescripcion']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            //$this->setmensajeoperacion("rol->listar: " . $base->getError());
        }
        return $arreglo;
    }

    function __toString()
    {
        return $this->getRolDescripcion();
    }
}
