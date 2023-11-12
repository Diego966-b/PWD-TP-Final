<?php
class UsuarioRol
{

    // Atributos

    private $objUsuario, $objRol, $mensajeOperacion;

    // Constructor y setear

    public function __construct()
    {
        $this->objUsuario = new Usuario();
        $this->objRol = new Rol();
        $this->mensajeOperacion = "";
    }

    public function setear($objUsuario, $objRol)
    {
        $this -> setObjUsuario ($objUsuario);
        $this -> setObjRol ($objRol);
    }

    // Gets

    public function getObjUsuario() { return $this->objUsuario; }
    public function getObjRol() { return $this->objRol; }
    public function getMensajeOperacion() { return $this->mensajeoperacion; }

    // Sets

    public function setObjUsuario($objUsuarioNuevo) { $this->objUsuario = $objUsuarioNuevo; }
    public function setObjRol($objRolNuevo) { $this->objRol = $objRolNuevo; }
    public function setMensajeOperacion($mensaje) { $this->mensajeoperacion = $mensaje; }

    // Métodos

    public function cargar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $objUsuario = $this->getObjUsuario();
        $objRol = $this->getObjRol();
        $sql = 
        "SELECT * FROM rol WHERE idUsuario = " . $objUsuario->getIdUsuario()." AND idRol = ".$objRol->getIdRol();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $abmUsuario = new AbmUsuario ();
                    $abmRol = new AbmRol ();
                    $array = [];
                    $array ['idUsuario'] = $row['idUsuario'];
                    $array ['idRol'] = $row['idRol'];
                    // MODIFICADO!!!
                    $listaUsuarios = $abmUsuario -> buscar ($array);
                    $listaRoles = $abmRol -> buscar ($array);
                    $objUsuario = $listaUsuarios[0];
                    $objRol = $listaRoles[0];
                    // MODIFICADO!!!
                    $this->setear($objUsuario, $objRol);
                }
            }
        } else {
            $this->setMensajeOperacion("usuarioRol->listar: " . $base->getError());
        }
        return $respuesta;
    }

    public function insertar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $objUsuarioDeverdad = $this->getObjUsuario();
        $objRolDeVerdad = $this->getObjRol();
        /*
        MODIFICADO!!!
            $objUsuarioDeverdad = $objUsuario[0]; //Modificado por Marco
            $objRolDeVerdad = $objRol[0]; //Modificado por Marco  
        MODIFICADO!!!
        */
        $sql = 
        "INSERT INTO usuarioRol (idUsuario, idRol)
            VALUES ('" . $objUsuarioDeverdad->getIdUsuario() . "', '" . $objRolDeVerdad->getIdRol() . "')";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("usuarioRol->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuarioRol->modificar: " . $base->getError());
        }
        return $respuesta;
    }

    public function modificar(){
        $resp = false;
        return $resp;
    }

    public function eliminar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $objUsuario = $this->getObjUsuario();
        $objRol = $this->getObjRol();
        $sql = "DELETE FROM usuarioRol WHERE idUsuario = " . $objUsuario->getIdUsuario()." AND idRol = ".$objRol->getIdRol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("usuarioRol->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuarioRol->eliminar: " . $base->getError());
        }
        return $respuesta;
    }

    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos;
        $sql = "SELECT * FROM usuarioRol ";
        if ($parametro != "") {
            $sql .= "WHERE " . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $abmUsuario = new AbmUsuario ();
                    $abmRol = new AbmRol ();
                    $obj = new UsuarioRol();
                    $array = [];
                    $array ['idUsuario'] = $row['idUsuario'];
                    $array ['idRol'] = $row['idRol'];
                    // MODIFICADO!!!
                    $listaUsuarios = $abmUsuario -> buscar ($array);
                    $listaRoles = $abmRol -> buscar ($array);
                    $objUsuario = $listaUsuarios[0];
                    $objRol = $listaRoles[0];
                    // MODIFICADO!!!
                    $obj->setear($objUsuario, $objRol);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            //$this->setMensajeoperacion("usuarioRol->listar: " . $base->getError());
        }
        return $arreglo;
    }

    public function setearConClave($param){
        $objRol = $this -> getObjRol();
        $objUsuario = $this -> getObjUsuario();
        $objRol->setIdRol($param['idRol']);
        $objUsuario->setIdUsuario($param['idUsuario']);
    }

    public function __toString()
    {
        $objRol = $this->getObjRol();
        $objUsuario = $this -> getObjUsuario();
        $frase =
            "<br>El id del rol es: " . $objRol->getIdRol() .
            ".<br>El id del usuario es: " . $objUsuario->getIdUsuario()."<br>";
        return $frase;
    }
}
?>