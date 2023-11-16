<?php
class AbmProducto
{
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
                if ($this->bajaLogica($datos)) 
                {
                    $array ["exito"] = true;
                }
            }
            if ($datos['accion'] == 'alta') {
                $datos ["proDeshabilitado"] = null;
                if ($this->altaLogica($datos)) {
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
    private function cargarObjeto($param)
    {
        $obj = null;
        if(array_key_exists('idProducto', $param) && array_key_exists('proNombre', $param) && 
        array_key_exists('proDetalle', $param) && array_key_exists('proCantStock', $param) &&
        array_key_exists('proImagen', $param) && array_key_exists('proPrecio', $param)) {
            $obj = new Producto();
            $obj->setear(
                $param['idProducto'], $param['proNombre'], 
                $param['proDetalle'], $param['proCantStock'], 
                $param['proImagen'], $param['proPrecio'],
                null);
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
        if (isset($param['idProducto'])) {
            $obj = new Producto();
            $obj->setear($param['idProducto'], null, null, null, null, null, null);
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
        if (isset($param['idProducto'])) {
            $respuesta = true;
        }
        return $respuesta;
    }
    /**
     * Carga un producto a la BD. Espera un array como parametro.
     * Retorna un booleano
     * @param array $param
     * @return boolean
     */
    public function alta($param)
    {
        $respuesta = false;
        $param['idProducto'] = null;
        $elObjProducto = $this->cargarObjeto($param);
        if ($elObjProducto != null and $elObjProducto->insertar()) {
            $respuesta = true;
        }
        return $respuesta;
    }

    /**
     * Borra un producto de la BD. Espera un array como parametro.
     * Retorna un booleano
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        $respuesta = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjProducto = $this->cargarObjetoConClave($param);
            if ($elObjProducto != null && $elObjProducto->eliminar()) {
                $respuesta = true;
            }
        }
        return $respuesta;
    }

    /**
     * Modifica un producto. Espera un array como parametro.
     * Retorna un booleano.
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        $respuesta = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjProducto = $this->cargarObjeto($param);
            if ($elObjProducto != null and $elObjProducto->modificar()) {
                $respuesta = true;
            }
        }
        return $respuesta;
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
            $listaProductos = $this->buscar($param);
            $producto=$listaProductos[0];
            if($producto->activarProducto()){
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
            $listaProductos = $this->buscar($param);
            $producto=$listaProductos[0];
            if($producto->eliminarLogico()){
                $resp = true;
            }
        }
        return $resp;
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
            if (isset($param['idProducto'])) {
                $where .= " and idProducto =" . $param['idProducto'];
            }
            if (isset($param['proNombre'])) {
                $where .= " and proNombre ='" . $param['proNombre'] . "'";
            }
            if (isset($param['proDetalle'])) {
                $where .= " and proDetalle ='" . $param['proDetalle']. "'";
            }
            if (isset($param['proCantStock'])) {
                $where .= " and proCantStock =" . $param['proCantStock'];
            }  
            if (isset($param['proImagen'])) {
                $where .= " and proImagen ='" . $param['proImagen'] . "'";
            }
            if (isset($param['proPrecio'])) {
                $where .= " and proPrecio =" . $param['proPrecio'];
            }
            if  (isset($param['proDeshabilitado'])) 
            {
                $where.=" and proDeshabilitado is null";
            }  
        }
        $arreglo = Producto::listar($where);
        return $arreglo;
    }
}
?>