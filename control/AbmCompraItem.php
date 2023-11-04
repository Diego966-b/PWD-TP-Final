<?php
class AbmCompraItem
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
        if (array_key_exists('idCompraItem',$param) and array_key_exists('ciCantidad',$param) and
            array_key_exists('idProducto',$param) and array_key_exists('idCompra',$param))
        {
            $obj = new CompraItem();
            $abmProducto = new AbmProducto();
            $abmCompra = new AbmCompra();
            $array = [];
            $array ['idCompra'] = $param['idCompra'];
            $array ['idProducto'] = $param['idProducto'];
            // MODIFICADO!!!
            $listaCompras = $abmCompra -> buscar ($array);
            $listaProductos = $abmProducto -> buscar ($array);
            $objCompra = $listaCompras[0];
            $objProducto = $listaProductos[0];
            // MODIFICADO!!!
            $idCompraItem = $param ['idCompraItem'];
            $ciCantidad = $param ['ciCantidad'];
            $obj -> setear($idCompraItem, $ciCantidad, $objProducto, $objCompra);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves.
     * @param array $param
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        if (isset($param['idCompraItem'])) {
            $obj = new CompraItem();
            $obj -> setear($param['idCompraItem'], null, null, null);
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
        if (isset($param['idCompraItem']))
            $resp = true;
        return $resp;
    }
    
    /**
     * Carga un compraItem a la BD. Espera un array como parametro.
     * Retorna un booleano
     * @param array $param
     * @return boolean
     */
    public function alta($param){
        $resp = false;
        $elObjCompraItem = $this->cargarObjeto($param);
        if ($elObjCompraItem!=null and $elObjCompraItem->insertar()){
            $resp = true;
        }
        return $resp;
    }

    /**
     * Borra un compraItem de la BD. Espera un array como parametro.
     * Retorna un booleano.
     * @param array $param
     * @return boolean
     */
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjCompraItem = $this->cargarObjetoConClave($param); 
            if ($elObjCompraItem!=null and $elObjCompraItem->eliminar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    /**
     * Modifica un compraItem. Espera un array como parametro.
     * Retorna un booleano.
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjCompraItem = $this->cargarObjeto($param);
            if($elObjCompraItem!=null and $elObjCompraItem->modificar()){
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
            if  (isset($param['idCompraItem'])) {
                $where.=" and idCompraItem=".$param['idCompraItem'];
            }
            if  (isset($param['ciCantidad'])) {
                $where.=" and ciCantidad ='".$param['ciCantidad']."'";
            }
            if  (isset($param['idProducto'])) {
                $where.=" and idProducto=".$param['idProducto'];
            }
            if  (isset($param['idCompra'])) {
                $where.=" and idCompra ='".$param['idCompra']."'";
            }
        }
        $arreglo = CompraItem::listar($where);
        return $arreglo;  
    }
}
?>