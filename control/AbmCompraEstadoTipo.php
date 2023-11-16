<?php 
class AbmCompraEstadoTipo
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
        if (array_key_exists('idCompraEstadoTipo',$param) and array_key_exists('cetDescripcion',$param) and
            array_key_exists('cetDetalle',$param))
        {
            $obj = new CompraEstadoTipo();
            $idCompraEstadoTipo = $param['idCompraEstadoTipo'];
            $cetDescripcion = $param['cetDescripcion'];
            $cetDetalle = $param['cetDetalle'];
            $obj -> setear ($idCompraEstadoTipo, $cetDescripcion, $cetDetalle);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves.
     * @param array $param
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        if (isset($param['idCompraEstadoTipo'])) {
            $obj = new CompraEstadoTipo();
            $obj -> setear($param['idCompra'], null, null);
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
        if (isset($param['idCompraEstadoTipo']))
            $resp = true;
        return $resp;
    }
    
    /**
     * Carga un CompraEstadoTipo a la BD. Espera un array como parametro.
     * Retorna un booleano
     * @param array $param
     * @return boolean
     */
    public function alta($param){
        $resp = false;
        $param['idCompraEstadoTipo'] = null; 
        $elObjCompraEstadoTipo = $this->cargarObjeto($param);
        if ($elObjCompraEstadoTipo!=null and $elObjCompraEstadoTipo->insertar()){
            $resp = true;
        }
        return $resp;
    }

    /**
     * Borra un CompraEstadoTipo de la BD. Espera un array como parametro.
     * Retorna un booleano.
     * @param array $param
     * @return boolean
     */
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjCompraEstadoTipo = $this->cargarObjetoConClave($param); 
            if ($elObjCompraEstadoTipo!=null and $elObjCompraEstadoTipo->eliminar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    /**
     * Modifica un CompraEstadoTipo. Espera un array como parametro.
     * Retorna un booleano.
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjCompraEstadoTipo = $this->cargarObjeto($param);
            if($elObjCompraEstadoTipo!=null and $elObjCompraEstadoTipo->modificar()){
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
            if  (isset($param['idCompraEstadoTipo'])) {
                $where.=" and idCompraEstadoTipo=".$param['idCompraEstadoTipo'];
            }
            if  (isset($param['cetDescripcion'])) {
                $where.=" and cetDescripcion ='".$param['cetDescripcion']."'";
            }
            if  (isset($param['cetDetalle'])) {
                $where.=" and cetDetalle=".$param['cetDetalle'];
            }
        }
        $arreglo = CompraEstadoTipo::listar($where);
        return $arreglo;  
    }
}
?>