<?php
class Usuario
{

    // Atributos

    private $idUsuario, $usNombre, $usPass, $usMail, $usDeshabilitado, $mensajeOperacion;

    // Constructor y setear

    public function __construct()
    {
        $this->idUsuario = '';
        $this->usNombre = '';
        $this->usPass = '';
        $this->usMail = '';
        $this->usDeshabilitado = '';
        $this->mensajeOperacion = '';
    }

    public function setear($idUsuario, $usNombre, $usPass, $usMail, $usDeshabilitado)
    {
        $this->setIdUsuario($idUsuario);
        $this->setUsNombre($usNombre) ;
        $this->setUsPass($usPass);
        $this->setUsMail($usMail);
        $this->setUsDeshabilitado($usDeshabilitado);
    }

    // Sets

    public function setIdUsuario($idUsuarioNuevo) {$this->idUsuario= $idUsuarioNuevo;}
    public function setUsNombre($usNombreNuevo) { $this->usNombre = $usNombreNuevo;}
    public function setUsPass($usPassNuevo){$this->usPass= $usPassNuevo;}
    public function setUsMail($usMailNuevo){$this->usMail= $usMailNuevo;}
    public function setUsDeshabilitado($usDeshabilitadoNuevo){$this->usDeshabilitado= $usDeshabilitadoNuevo;}
    public function setMensajeOperacion($mensajeOperacionNuevo){$this->mensajeOperacion = $mensajeOperacionNuevo;}

    // Gets

    public function getIdUsuario() { return $this->idUsuario; }
    public function getUsNombre() { return $this->usNombre; }
    public function getUsPass() { return $this->usPass; }
    public function getUsMail() { return $this->usMail; }
    public function getUsDeshabilitado() { return $this->usDeshabilitado; }
    public function getMensajeOperacion() { return $this->mensajeOperacion; }

    // Metodos

    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = 
        "SELECT * FROM usuario WHERE idUsuario = " . $this->getIdUsuario();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $idUsuario = $row['idUsuario'];
                    $usNombre = $row['usNombre'];
                    $usPass = $row['usPass'];
                    $usMail = $row['usMail'];
                    $usDeshabilitado = $row['usDeshabilitado'];
                    $this->setear($idUsuario, $usNombre, $usPass, $usMail,$usDeshabilitado);
                }
            }
        } else {
            $this->setmensajeoperacion("Usuario->listar: " . $base->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        // no paso el id por que es autoIncrement
        $sql = 
        "INSERT INTO usuario (usNombre, usPass, usMail, usDeshabilitado)  
        VALUES('" . $this->getUsNombre() . "', '" . $this->getUsPass() . "', '" . $this->getUsMail() . "', NULL);"; // MODIFICADO!!!
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("usuario->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("usuario->insertar: " . $base->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = 
        "UPDATE usuario SET 
            idUsuario='" . $this->getIdUsuario() . "',
            usNombre='" . $this->getUsNombre() . "',
            usPass='" . $this->getUsPass()."',
            usMail='" . $this->getUsMail()."'
        WHERE idUsuario='" . $this->getIdUsuario() . "'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("usuario->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("usuario->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = 
        "DELETE FROM usuario WHERE idUsuario=" . $this->getIdUsuario();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("usuario->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("usuario->eliminar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminarLogico(){
        $resp = false;
        $base = new BaseDatos();
        $sql = 
        "UPDATE usuario SET usDeshabilitado = NOW() WHERE idUsuario='" . $this->getIdUsuario() . "'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("usuario->eliminarLogico: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("usuario->eliminarLogico: " . $base->getError());
        }
        return $resp;
    }

    public function activarUsuario (){
        $resp = false;
        $base = new BaseDatos();
        $sql = 
        "UPDATE usuario SET usDeshabilitado = null WHERE idUsuario='" . $this->getIdUsuario() . "'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("usuario->eliminarLogico: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("usuario->eliminarLogico: " . $base->getError());
        }
        return $resp;
    }

    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuario ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new Usuario();
                    $idUsuario = $row['idUsuario'];
                    $usNombre = $row['usNombre'];
                    $usPass = $row['usPass'];
                    $usMail = $row['usMail'];
                    $usDeshabilitado = $row['usDeshabilitado'];
                    $obj->setear($idUsuario, $usNombre, $usPass, $usMail,$usDeshabilitado);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            //$this->setmensajeoperacion("usuario->listar: " . $base->getError());
        }
        return $arreglo;
    }

    public function __toString()
    {
        $frase =
            "<br>El Id del Usuario es: " . $this->getIdUsuario() .
            ".<br>El nombre es: " . $this->getUsNombre() .
            ".<br>La password es: " . $this->getUsPass() .
            ".<br>El mail es: " . $this->getUsMail().
            ".<br>su estado es: " . $this->getUsDeshabilitado()."<br>";
        return $frase;
    }
}