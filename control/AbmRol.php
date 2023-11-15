<?php
class AbmRol {

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
            if($datos['accion']=='alta')
            {
                if ($this->altaL($datos)) {
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
    private function cargarObjeto($param)
    {
        $obj = null;
        if(array_key_exists('idRol', $param) && array_key_exists('rolDescripcion', $param) && array_key_exists('rolDeshabilitado', $param)){
            $obj = new Rol();
            $obj->setear($param['idRol'], $param['rolDescripcion'],$param['rolDeshabilitado']);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idRol'])) {
            $obj = new Rol();
            $obj->setear($param['idRol'], null,null);
        }
        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
     private function seteadosCamposClaves($param)
     {
         $respuesta = false;
         if (isset($param['idRol'])) {
             $respuesta = true;
         }
         return $respuesta;
     }
    
    /**
     * Carga un rol a la BD. Espera un array como parametro.
     * Retorna un booleano
     * @param array $param
     * @return boolean
     */
    public function alta($param)
    {
        $respuesta = false;
        $param['idRol'] = null;
        $param['rolDeshabilitado']= NULL;
        $elObjRol = $this->cargarObjeto($param);
        if ($elObjRol != null and $elObjRol->insertar()) {
            $respuesta = true;
        }
        return $respuesta;
    }

    /**
     * Borra un rol de la BD. Espera un array como parametro.
     * Retorna un booleano
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        $respuesta = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjRol = $this->cargarObjetoConClave($param);
            if ($elObjRol != null && $elObjRol->eliminarLogico()) {
                $respuesta = true;
            }
        }
        return $respuesta;
    }
    public function altaL($param)
    {
        $respuesta = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjRol = $this->cargarObjetoConClave($param);
            if ($elObjRol != null && $elObjRol->altaLogica()) {
                $respuesta = true;
            }
        }
        return $respuesta;
    }

    /**
     * Modifica un rol. Espera un array como parametro.
     * Retorna un booleano.
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        $respuesta = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjRol = $this->cargarObjeto($param);
            if ($elObjRol != null and $elObjRol->modificar()) {
                $respuesta = true;
            }
        }
        return $respuesta;
    }

    /**
     * Busca en la BD con o sin parametros. Espera un array como parametro.
     * Retorna un array con lo encontrado.
     * @param array $param
     * @return array
     */
    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idRol'])) {
                $where .= " and idRol =" . $param['idRol'];
            }
            if (isset($param['rolDescripcion'])) {
                $where .= " and rolDescripcion ='" . $param['rolDescripcion'] . "'";
            }
        }
        $arreglo = Rol::listar($where);
        return $arreglo;
    }
}