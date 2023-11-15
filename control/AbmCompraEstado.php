<?php 
class AbmCompraEstado
{
        
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
        if (array_key_exists('idCompraEstado',$param) and array_key_exists('idCompra',$param) and
            array_key_exists('idCompraEstadoTipo',$param) and array_key_exists('ceFechaIni',$param) and 
            array_key_exists('ceFechaFin',$param))
        {
            $obj = new CompraEstado();
            $abmCompra = new AbmCompra ();
            $abmCompraEstadoTipo = new AbmCompraEstadoTipo();
            $arrayCompra = [];
            $arrayCompraEstadoTipo = [];
            $arrayCompra ['idCompra'] = $param['idCompra'];
            $arrayCompraEstadoTipo ['idCompraEstadoTipo'] = $param['idCompraEstadoTipo']; // Modificado!!!
            // MODIFICADO!!!
            $listaCompras = $abmCompra -> buscar ($arrayCompra);
            $listaCompraEstadoTipo = $abmCompraEstadoTipo -> buscar ($arrayCompraEstadoTipo);
            $objCompra = $listaCompras[0];
            $objCompraEstadoTipo = $listaCompraEstadoTipo[0];
            // MODIFICADO!!!
            $idCompraEstado = $param ['idCompraEstado'];
            $ceFechaIni = $param ['ceFechaIni'];
            $ceFechaFin = $param ['ceFechaFin'];

            $obj -> setear($idCompraEstado, $objCompra, $objCompraEstadoTipo, $ceFechaIni, $ceFechaFin);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves.
     * @param array $param
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        if (isset($param['idCompraEstado'])) {
            $obj = new CompraEstado();
            $obj -> setear($param['idCompraEstado'], null, null, null, null);
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
        if (isset($param['idCompraEstado']))
            $resp = true;
        return $resp;
    }
    
    /**
     * Carga un CompraEstado a la BD. Espera un array como parametro.
     * Retorna un booleano
     * @param array $param
     * @return boolean
     */
    public function alta($param){
        $resp = false;
        $param['idCompraEstado'] = null; // MODIFICADO!!!
        $elObjCompraEstado = $this->cargarObjeto($param);
        if ($elObjCompraEstado!=null and $elObjCompraEstado->insertar()){
            $resp = true;
        }
        return $resp;
    }

    /**
     * Borra un CompraEstado de la BD. Espera un array como parametro.
     * Retorna un booleano.
     * @param array $param
     * @return boolean
     */
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjCompraEstado = $this->cargarObjetoConClave($param); 
            if ($elObjCompraEstado!=null and $elObjCompraEstado->eliminar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    /**
     * Modifica un CompraEstado. Espera un array como parametro.
     * Retorna un booleano.
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjCompraEstado = $this->cargarObjeto($param);
            if($elObjCompraEstado!=null and $elObjCompraEstado->modificar()){
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
    public function buscar($param){
        $where = " true ";
        if ($param<>NULL)
        {
            if  (isset($param['idCompraEstado'])) {
                $where.=" and idCompraEstado=".$param['idCompraEstado'];
            }
            if  (isset($param['idCompra'])) {
                $where.=" and idCompra ='".$param['idCompra']."'";
            }
            if  (isset($param['idCompraEstadoTipo'])) {
                $where.=" and idCompraEstadoTipo=".$param['idCompraEstadoTipo'];
            }
            if  (isset($param['ceFechaIni'])) {
                $where.=" and ceFechaIni ='".$param['ceFechaIni']."'";
            }
            if  (isset($param['ceFechaFin'])) {
                $where.=" and ceFechaFin=".$param['ceFechaFin'];
            }
        }
        $arreglo = CompraEstado::listar($where);
        return $arreglo;  
    }
}
?>