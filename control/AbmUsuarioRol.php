<?php
class AbmUsuarioRol {
    
    // Metodos

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
                if ($this->modificacion($datos)) {
                    $array ["exito"] = true;
                }
            }
            if($datos['accion']=='borrar') 
            {
                if ($this->baja($datos)) 
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
            if ($array ["exito"]) {
                $array ["mensaje"] = "<h3 class='text-success'>La accion " . $datos['accion'] . " se realizo correctamente.</h3>";
            } else {
                $array ["mensaje"] = "<h3 class='text-danger'>La accion " . $datos['accion'] . " no pudo concretarse.</h3>";
            } 
        }
        return $array;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto.
     * @param array $param
     */
    private function cargarObjeto ($param){
        $obj = null;
        if (array_key_exists('idUsuario',$param) and array_key_exists('idRol',$param))
        {
            //Inicio modificacion Marco
            $obj = new UsuarioRol();
            $abmUsuario = new AbmUsuario ();
            $abmRol = new AbmRol ();
            $array = [];
            $array ['idUsuario'] = $param['idUsuario'];
            $array ['idRol'] = $param['idRol'];
            $listaUsuarios = $abmUsuario -> buscar ($array);
            $listaRoles = $abmRol -> buscar ($array);
            $objUsuario = $listaUsuarios[0];
            $objRol = $listaRoles[0];
            $obj -> setear($objUsuario, $objRol);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves.
     * ES IGUAL A cargarObjeto()
     * @param array $param
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        if (isset($param['idUsuario']) && isset($param['idRol'])) {
            $obj = new UsuarioRol();
            $abmUsuario = new AbmUsuario ();
            $abmRol = new AbmRol ();
            $array = [];
            $array ['idUsuario'] = $param['idUsuario'];
            $array ['idRol'] = $param['idRol'];
            $listaUsuarios = $abmUsuario -> buscar ($array);
            $listaRoles = $abmRol -> buscar ($array);
            $objUsuario = $listaUsuarios[0];
            $objRol = $listaRoles[0];
            $obj -> setear($objUsuario, $objRol);
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
        if (isset($param['idRol']) && (isset($param['idUsuario']))) // VER!!!
            $resp = true;
        return $resp;
    }
    
    /**
     * Carga un usuarioRol a la BD. Espera un array como parametro.
     * Retorna un booleano
     * @param array $param
     * @return boolean
     */
    public function alta($param){
        $resp = false;
        $elObjUsuarioRol = $this->cargarObjeto($param);
        if ($elObjUsuarioRol!=null and $elObjUsuarioRol->insertar()){
            $resp = true;
        }
        return $resp;
    }

    /**
     * Borra un usuarioRol de la BD. Espera un array como parametro.
     * Retorna un booleano.
     * @param array $param
     * @return boolean
     */
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjUsuarioRol = $this->cargarObjetoConClave($param);
            if ($elObjUsuarioRol!=null and $elObjUsuarioRol->eliminar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    /**
     * Modifica un usuarioRol. Espera un array como parametro.
     * Retorna un booleano.
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjUsuarioRol = $this->cargarObjeto($param);
            if($elObjUsuarioRol!=null and $elObjUsuarioRol->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    /**
     * Busca en la BD con o sin parametros. Espera un array como parametro.
     * Retorna un array con lo encontrado.
     * @param array $param
     */
    public function buscar($param){
        $where = " true ";
        if ($param<>NULL)
        {
            if  (isset($param['idUsuario'])) {
                $where.=" and idUsuario=".$param['idUsuario'];
            }
            if  (isset($param['idRol'])) {
                $where.=" and idRol ='".$param['idRol']."'";
            }
        }
        $arreglo = UsuarioRol::listar($where);
        return $arreglo;  
    }
}
?>