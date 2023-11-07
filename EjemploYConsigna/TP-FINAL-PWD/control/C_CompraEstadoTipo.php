<?php
class C_CompraEstadoTipo{
    
    /**
     * @param array $param
     * @return CompraEstadoTipo
     */
    private function cargarObjeto($param)
    {
        $obj = null;
        if (array_key_exists('idCompraEstadoTipo', $param) and array_key_exists('cetDescripcion', $param)
            and array_key_exists('cetDetalle', $param)){

            $obj = new CompraEstadoTipo();
            $obj->setear($param['idCompraEstadoTipo'], $param['cetDescripcion'], $param['cetDetalle']);
        }
        return $obj;
    }

     /**
     * @param array $param
     * @return CompraEstadoTipo
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        if (isset($param['idCompraEstadoTipo'])) {
            $obj = new CompraEstadoTipo();
            $obj->setear($param['idCompraEstadoTipo'], null, null, null, null);
        }
        return $obj;
    }

    /**
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
     * Inserta en la base de datos
     * @param array $param
     * @return boolean
     */
    public function alta($param){
        $resp = false;
        $param['idCompraEstadoTipo'] = null;
        $obj = $this->cargarObjeto($param);
        if ($obj != null and $obj->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $obj = $this->cargarObjetoConClave($param);
            if ($obj !=null and $obj->eliminar()){
                $resp = true;
            }
        }
        return $resp;
    } 

    /**
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $obj = $this->cargarObjeto($param);
            if ($obj != null and $obj->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }


    /**
     * @param array $param
     * @return array
     */
    public function buscar($param)
    {
        $where = " true ";
        if ($param != null) {
            if (isset($param['idCompraEstadoTipo']))
                $where .= " and idCompraEstadoTipo =" . $param['idCompraEstadoTipo'];
            if (isset($param['cetDetalle']))
                $where .= " and cetDetalle =" . $param['cetDetalle'];
            if (isset($param['cetDescripcion']))
                $where .= " and cetDescripcion ='" . $param['cetDescripcion'] . "'";
        }

        $obj = new CompraEstadoTipo();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }

}

?>