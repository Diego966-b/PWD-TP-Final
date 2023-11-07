<?php
class Usuario{
    private $idUsuario;
    private $usNombre;
    private $usPass;
    private $usMail;
    private $usDeshabilitado;
    private $mensajeOperacion;
    
    /**************************************/
    /**************** SET *****************/
    /**************************************/
    
    public function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;
    }

    public function setUsNombre($usNombre){
        $this->usNombre = $usNombre;
    }
    
    public function setUsPass($usPass){
        $this->usPass = $usPass;
    }

    public function setUsMail($usMail){
        $this->usMail = $usMail;
    }

    public function setUsDeshabilitado($usDeshabilitado){
        $this->usDeshabilitado = $usDeshabilitado;
    }

    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }
    
    /**************************************/
    /**************** GET *****************/
    /**************************************/
    
    public function getIdUsuario(){
        return $this->idUsuario;
    }
    
    public function getUsNombre(){
        return $this->usNombre;
    }

    public function getUsPass(){
        return $this->usPass;
    }
    
    public function getUsMail(){
        return $this->usMail;
    }

    public function getUsDeshabilitado(){
        return $this->usDeshabilitado;
    }

    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }
    
    /**************************************/
    /************** FUNCIONES *************/
    /**************************************/
    

    public function __construct(){
        $this->idUsuario = "";
        $this->usNombre = "";
        $this->usPass = "";
        $this->usMail = "";
        $this->usDeshabilitado = "";
        $this->mensajeOperacion="";
    }

    public function setear($idUsuario,$usNombre, $usPass, $usMail, $usDeshabilitado){
        $this->setIdUsuario($idUsuario);
        $this->setUsNombre($usNombre);
        $this->setUsPass($usPass);
        $this->setUsMail($usMail);
        $this->setUsDeshabilitado($usDeshabilitado);
    }

    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        if($this->getIdUsuario()!=''){
            $sql = "SELECT * FROM usuario WHERE idUsuario = " . $this->getIdUsuario();
        }
        //echo $sql;
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['idUsuario'], $row['usNombre'], $row['usPass'], $row['usMail'], $row['usDeshabilitado']);
					$resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("usuario->listar: " . $base->getError());
        }
        return $resp;
    }

    public function insertar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO usuario(usNombre,usPass,usMail) 
                VALUES('" .$this->getUsNombre(). "','" 
                .$this->getUsPass(). "','" 
                .$this->getUsMail(). "');";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdUsuario($elid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("usuario->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuario->insertar: " . $base->getError());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $deshabilitado = $this->getUsDeshabilitado();
        if($deshabilitado==null){
            //PARA EL CASO QUE QUIERA MODIFICAR OBJETO SIN TOCAR USDESHABILITADO
            $deshabilitado=='';
        }else if($deshabilitado=='habilitar'){
            //PARA EL CASO QUE QUIERA HABILITARLO
            $deshabilitado=",usDeshabilitado=NULL";
        }else {
            //PARA EL CASO QUE QUIERA DESHABILITARLO
            $deshabilitado=",usDeshabilitado='".$this->getUsDeshabilitado()."' ";
        }
        $sql = "UPDATE usuario SET usNombre='" . $this->getUsNombre() . "',
        usPass='" . $this->getUsPass() . "',
        usMail='" . $this->getUsMail()."' $deshabilitado
        WHERE idUsuario=" . $this->getIdUsuario();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("usuario->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuario->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM usuario WHERE idUsuario=" . $this->getIdUsuario();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("usuario->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuario->eliminar: " . $base->getError());
        }
        return $resp;
    }

    public static function listar($parametro = ""){
        $arreglo = null;
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuario ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        } 
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
				$arreglo = array();
                while ($row = $base->Registro()) {
                    $obj = new Usuario();
                    $obj->setear($row['idUsuario'],$row['usNombre'], $row['usPass'], $row['usMail'], $row['usDeshabilitado']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeOperacion("Usuario->listar: " . $base->getError());
        }
        return $arreglo;
    }
}
