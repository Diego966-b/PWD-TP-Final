<?php
class C_Session{

    private $objUsuario;       

/**************************************/
/**************** SET *****************/
/**************************************/

    /**
     * Establece el valor de objUsuario
     */ 
    public function setObjUsuario($objUsuario){
        $this->objUsuario = $objUsuario;
    }

/**************************************/
/**************** GET *****************/
/**************************************/

        /**
     * Obtiene el valor de objUsuario
     */ 
    public function getObjUsuario(){
        return $this->objUsuario;
    }

/**************************************/
/************** FUNCIONES *************/
/**************************************/

    public function __construct(){
        session_start();
        $this->setObjUsuario(new C_Usuario());
        if(isset($_SESSION["nombreUsuario"])){
            $usNombre["usNombre"] = $_SESSION["nombreUsuario"];
            $usuario = $this->getObjUsuario()->buscar($usNombre);
            $this->setObjUsuario($usuario[0]);
        }
    }

    private function iniciar($nombreUsuario, $arrayRoles){
        $_SESSION["nombreUsuario"] = $nombreUsuario;
        $_SESSION["roles"] = $arrayRoles;
        $objRol = new C_Rol();
        $param = [2];
        $_SESSION["vista"] = $objRol->obtenerObj($param)[0];
    }

    public function valida($param){
        $arrayUsuario = $this->getObjUsuario()->buscar($param);
        $resp = false;
        if($arrayUsuario != null){
            if($param["usPass"] == $arrayUsuario[0]->getUsPass()){
                $this->setObjUsuario($arrayUsuario[0]);
                $idRoles = $this->getRol();
                $this->iniciar($param["usNombre"], $idRoles);
                $resp = true;
            }
        }
        return $resp;
    }

    public function activa(){
        $resp=isset($_SESSION["nombreUsuario"])? TRUE : FALSE;
        return $resp;
    }

    public function getUsuario(){
        $resp = null;
        if($this->getObjUsuario() != null){
            $resp = $this->getObjUsuario();
        }
        return $resp;
    }

    public function getRol(){
        if($this->getObjUsuario() != null){
            $objUsuarioRol = new C_UsuarioRol();
            $param["idUsuario"] = $this->getObjUsuario()->getIdUsuario();
            $arrayRolesUsuario = $objUsuarioRol->buscar($param);
            $arrayRol = [];
                foreach($arrayRolesUsuario as $rol){
                    array_push($arrayRol, $rol->getRol());
                }
                $idRoles=[];
                foreach($arrayRol as $objRol){
                    array_push($idRoles,$objRol->getIdRol());
                }
        }
        return $idRoles;
    }

    public function cerrar(){
        $cerrar = false; 
        if(session_destroy()){
            $cerrar = true;
        }
        return $cerrar;
    }

    public function getVista(){
        $resp=NULL;
        if($_SESSION['vista']!=NULL){
            $resp=$_SESSION['vista'];
        }
        return $resp;
    }

}




?>