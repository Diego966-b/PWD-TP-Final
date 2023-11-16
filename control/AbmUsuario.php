<?php
class AbmUsuario{

    // Métodos

    /**
     * Funcion ABM. Espera un array de parametro. Indicando la accion a realizar.
     * Retorna un array con un mensaje y un booleano segun su exito.
     * @param array $datos
     * @return boolean
     */
    public function abm($datos){
        $array = [];
        $array ["exito"] = false;  
        $array ["mensaje"] = "";      
        if (isset($datos['accion'])) 
        {
            if($datos['accion']=='editar')
            {
                $objEncriptar = new Encriptar();
                $passEncriptada = $objEncriptar -> encriptarMd5($datos ["usPass"]);
                $datos["usPass"] = $passEncriptada;
                if ($this->modificacion($datos)) {
                    $array ["exito"] = true;
                }
            }
            if($datos['accion']=='borrar') 
            {
                if ($this->bajaLogica($datos)) 
                {
                    $array ["exito"] = true;
                }
            }
            if($datos['accion']=='nuevo')
            {
                if ($this->alta($datos)) {
                    $array ["exito"] = true;
                }
            }
            if ($datos['accion'] == 'alta') {
                $datos ["usDeshabilitado"] = null;
                if ($this->altaLogica($datos)) {
                    $array ["exito"] = true;
                }
            }
            if($datos['accion']=='borrarRol') 
            {
                if($this->borrarRol($datos))
                {
                    $array ["exito"] = true;
                }
            }
            if($datos['accion']=='nuevoRol') 
            {   
                if($this->altaRol($datos))
                {
                    $array ["exito"] = true;
                }
            }
            if($datos['accion']=='actualizarRol') 
            {   
                if($this->actualizarRol($datos)) 
                {
                    $array ["exito"] = true;
                }
            }
            if ($array ["exito"]) {
                $array ["mensaje"] = "La accion " . $datos['accion'] . " se realizo correctamente.";
            } else {
                $array ["mensaje"] = "La accion " . $datos['accion'] . " no pudo concretarse.";
            } 
        }
        return $array;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto.
     * @param array $param
     */
    private function cargarObjeto($param){
        $obj = null;
        if( array_key_exists('idUsuario',$param) and array_key_exists('usNombre',$param)and
        array_key_exists('usPass',$param) and array_key_exists('usMail',$param)){
            $obj = new Usuario();
            $obj->setear($param['idUsuario'], $param['usNombre'], $param['usPass'], $param['usMail'], null);
          }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if (isset($param['idUsuario'])) {
            $obj = new Usuario();
            $obj->setear($param['idUsaurio'], null, null, null,null);
        }
        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['idUsuario']))
        {
            $resp = true;
        }
        return $resp;
    }
    
    /**
     * Carga un usuario a la BD. Espera un array como parametro.
     * Retorna un booleano
     * @param array $param
     * @return boolean
     */
    public function alta($param){
        $resp = false;
        $param['idUsuario'] = null; 
        $elObjtUser= $this->cargarObjeto($param);
        if ($elObjtUser!=null and $elObjtUser->insertar()){
            $resp = true;
        }
        return $resp; 
    }

    /**
     * Realiza un alta logica, es decir setea en null el campo usDeshabilitado.
     * Retorna un booleano.
     * @param array $param
     * @return boolean
     */
    public function altaLogica ($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $objtUsers = $this->buscar($param);
            $user=$objtUsers[0];
            if($user->activarUsuario()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    /**
     * Borra un usuario de la BD. Espera un array como parametro.
     * Retorna un booleano
     * @param array $param
     * @return boolean
     */
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtUser = $this->cargarObjetoConClave($param);
            if ($elObjtUser!=null and $elObjtUser->eliminar()){
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Realiza un borrado logico. Espera un array como parametro.
     * Retorna un booleano.
     * @param array $param
     * @return boolean
     */
    public function bajaLogica($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $objtUsers = $this->buscar($param);
            $user=$objtUsers[0];
            if( $user->eliminarLogico()){
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Modifica un usuario. Espera un array como parametro.
     * Retorna un booleano.
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtUser = $this->cargarObjeto($param);
            if($elObjtUser!=null and $elObjtUser->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Devuelve los roles del usuario. Pide como parametro un arreglo asociativo.
     * @param array $param
     * @return array
     */
    public function darRoles($param){
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['idUsuario']))
                $where.=" and idUsuario =".$param['idUsuario'];
            if  (isset($param['idRol']))
                $where.=" and idRol ='".$param['idRol']."'";
        }
        $obj = new UsuarioRol();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }

    /**
     * Borra un rol del usuario. Pide como parametro un arreglo.
     * Retorna un booleano.
     * @param array $param
     * @return boolean
     */
    public function borrarRol($param){
        $resp = false;
        if(isset($param['idUsuario']) && isset($param['idRol'])){
            $elObjUsuarioRol = new UsuarioRol();
            $elObjUsuarioRol->setearConClave($param['idUsuario'],$param['idRol']);
            $resp = $elObjUsuarioRol->eliminar();
        }
        return $resp;
    }

    /**
     * Agrega un rol al usuario. Pide como parametro un arreglo.
     * Retorna un booleano.
     * @param array $param
     * @return boolean
     */
    public function altaRol($param){
        $resp = false;
        if(isset($param['idUsuario']) && isset($param['idRol'])){
            $elObjUsuarioRol = new UsuarioRol();
            $elObjUsuarioRol -> setearConClave($param);
            $resp = $elObjUsuarioRol->insertar();
        }
        return $resp;  
    }
     /**
     * Cambia el rol que tiene el usuario. Pide como parametro un arreglo.
     * Retorna un booleano.
     * @param array $param
     * @return boolean
     */
    public function actualizarRol($param){
        $resp = false;
        if(isset($param['idUsuario']) && isset($param['idRol'])){
            $amb= new AbmUsuarioRol();
            $resp=$amb->modificacion($param) ;  

        }
        return $resp;  
    }

    /**
     * Busca en la BD con o sin parametros. Espera un array como parametro.
     * Retorna un array con lo encontrado.
     * @param array $param
     * @return array
     */
    public function buscar($param){
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['idUsuario']))
            {
                $where.=" and idUsuario ='".$param['idUsuario']."'";
            }
            if  (isset($param['usNombre']))
            {
                $where.=" and usNombre ='".$param['usNombre']."'";
            }
            if  (isset($param['usPass'])) 
            {
                $where.=" and usPass ='".$param['usPass']."'";
            }
            if  (isset($param['usMail'])) 
            {
                $where.=" and usMail ='".$param['usMail']."'";
            }
            if  (isset($param['usDeshabilitado'])) 
            {
                $where.=" and usdeshabilitado is null";
            }    
        }
        $arreglo = Usuario::listar($where);  
        return $arreglo;  
    }
}
?>