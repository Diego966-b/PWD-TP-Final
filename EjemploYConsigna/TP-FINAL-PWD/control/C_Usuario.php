<?php

class C_Usuario
{

    //este es para crear un usuario
    private function cargarObjeto($param)
    {
        //print_r($param);
        $obj = null;
        if (array_key_exists('idUsuario', $param) and array_key_exists('usNombre', $param) and array_key_exists('usPass', $param) and array_key_exists('usMail', $param)) {
            $obj = new Usuario();
            if (array_key_exists('usDeshabilitado', $param)) {
                $obj->setear($param["idUsuario"], $param["usNombre"], $param["usPass"], $param["usMail"], $param["usDeshabilitado"]);
            } else {
                $obj->setear($param["idUsuario"], $param["usNombre"], $param["usPass"], $param["usMail"], NULL);
            }
        }
        return $obj;
    }

    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idUsuario'])) {
            $obj = new Usuario();
            $obj->setear($param['idUsuario'], null, null, null, null);
        }
        return $obj;
    }


    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idUsuario'])) {
            $resp = true;
        }
        return $resp;
    }

    public function alta($param)
    {
        $resp = false;
        $nombreUsuario["usNombre"] = $param["usNombre"];
        if ($this->buscar($nombreUsuario) == null) {
        $param['idUsuario'] = null;  // Se comenta ya que esta line es para cuando la base de datos tiene su clave principal Usuario incrementable
            $objUsuario = $this->cargarObjeto($param);
            if ($objUsuario != null && $objUsuario->insertar()) {
                if ($this->altaRol($objUsuario)) {
                    $resp = true;
                    //aca hice el alta del rolUsuario
                }
            }
        }
        return $resp;
    }

    public function altaRol($objUs)
    {
        $idUsCreado = $objUs->getIdUsuario();
        $usRol = new C_UsuarioRol();
        //por defecto al crearse el usuario se le asigna el rol de USER (id:2)
        $datosUsRol['idRol'] = 2;
        $datosUsRol['idUsuario'] = $idUsCreado;
        $resp = $usRol->alta($datosUsRol);
        return $resp;
    }

    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objUsuario = $this->cargarObjetoConClave($param);
            if ($objUsuario != null && $objUsuario->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function modificacion($param)
    {
        //echo "Estoy en modificacion";
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objUsuario = $this->cargarObjeto($param);
            if ($objUsuario != null and $objUsuario->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function buscar($param)
    {
        $where = "true";
        if ($param <> NULL) {
            if (isset($param['idUsuario']))
                $where .= " and idUsuario=" . $param['idUsuario'];
            if (isset($param['usNombre']))
                $where .= " and usNombre='" . $param['usNombre'] . "'";
            if (isset($param['usPass']))
                $where .= " and usPass='" . $param['usPass'] . "'";
            if (isset($param['usMail']))
                $where .= " and usMail='" . $param['$usMail'] . "'";
        }
        $objUsuario = new Usuario();
        $arreglo = $objUsuario->listar($where);
        return $arreglo;
    }


    public function cambiarRoles($param){
        $cambiado = false;
        $datos['idUsuario'] = $param['idUsuario'];
        $usuarios = $this->buscar($datos);
        $objUsuarioRol = new C_UsuarioRol();
        //aca obtengo los roles que tiene antes de modificar el usuario:
        $rolesIdViejos = $objUsuarioRol->darIdRoles($usuarios);
        //ahora obtengo los roles que pase por POST
        $roles = $param['rol'];
        if (count($rolesIdViejos[0])<count($roles)) {
            //si lo que hace es agregarRoles
            $cambiado=$this->agregarRoles($roles,$rolesIdViejos[0],$param);
        }else if(count($rolesIdViejos[0])>count($roles)){
            //si le quita roles
            $cambiado=$this->quitarRoles($roles,$rolesIdViejos[0],$param);
        }else{
            //si quita uno y agrega otro:
            $cambiado=$this->agregarRoles($roles,$rolesIdViejos[0],$param) && $this->quitarRoles($roles,$rolesIdViejos[0],$param);
        }
        return $cambiado;
    }

    private function agregarRoles($rolesNuevos,$rolesViejos,$param){
        $agregado=false;
        foreach($rolesNuevos as $rolAgregar){
            if(!in_array($rolAgregar,$rolesViejos)){
                $idUsuario = $param['idUsuario'];
                $modUsRol = new UsuarioRol();
                $modUsRol->setearConClave($idUsuario, $rolAgregar);
                $agregado = $modUsRol->insertar(); 
            }
        }
        return $agregado;
    }

    private function quitarRoles($rolesNuevos,$rolesViejos,$param){
        $eliminado=false;
        foreach($rolesViejos as $rolEliminar){
            if(!in_array($rolEliminar,$rolesNuevos)){
                $idUsuario = $param['idUsuario'];
                $modUsRol = new UsuarioRol();
                $modUsRol->setearConClave($idUsuario, $rolEliminar);
                $eliminado = $modUsRol->eliminar(); 
            }
        }
        return $eliminado;
    }

    function deshabilitar($param)
    {
        $resp = false;
        $arrayObjUsuarios = $this->buscar($param);
        $fecha = new DateTime();
        $fechaStamp = $fecha->format('Y-m-d H:i:s');
        $objUsuario = $arrayObjUsuarios[0];
        $objUsuario->setUsDeshabilitado($fechaStamp);
        if ($objUsuario != null and $objUsuario->modificar()) {
            $resp = true;
        }
        return $resp;
    }

    function habilitar($param)
    {
        $resp = false;
        $arrayObjUsuarios = $this->buscar($param);
        $objUsuario = $arrayObjUsuarios[0];
        $objUsuario->setUsDeshabilitado('habilitar');
        if ($objUsuario != null and $objUsuario->modificar()) {
            $resp = true;
        }
        return $resp;
    }
}
