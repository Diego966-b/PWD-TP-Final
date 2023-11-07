<?php
class C_Producto
{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto


    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */
    private function cargarObjeto($param)
    {
        $objProducto = null;

        if (array_key_exists('idProducto', $param) and array_key_exists('proNombre', $param) and array_key_exists('proDetalle', $param) and array_key_exists('proCantStock', $param) and  array_key_exists('proPrecio', $param) and array_key_exists('urlImagen', $param)) {
            $objProducto = new Producto();
            $objProducto->setear($param['idProducto'], $param['proNombre'], $param['proDetalle'], $param['proCantStock'], $param['proPrecio'], $param['urlImagen']);

            }
        return $objProducto;
    }

    /**
     * @param array $param
     * @return Producto
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idProducto'])) {
            $obj = new Producto();
            $obj->setear($param['idProducto'], null, null, null, null,null);
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
        $resp = false;
        
        if (isset($param['idProducto'])) {
            $resp = true;
        }
        return $resp;
    }

    /**
     *
     * @param array $param
     * @return boolean
     */
    public function alta($param)
    {
        $resp = false;
        $param['idProducto'] = null;
        $objProducto = $this->cargarObjeto($param);
        if ($objProducto!=null) {
            if($objProducto->insertar()){
                $resp = true;
            }
        }
        return $resp;
    }
    /**
     * permite eliminar un objeto
     * @param array $param
     * @return boolean
     */
    public function baja($param){
        $resp = false;

        if ($this->seteadosCamposClaves($param)) {
            $objProducto = $this->cargarObjetoConClave($param);
            if ($objProducto!=null and $objProducto->eliminar()){
                $resp = true;
            }
        }

        return $resp;
    }

    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        //echo "Estoy en modificacion";
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objProducto = $this->cargarObjeto($param);
            if ($objProducto!=null and $objProducto->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param = "")
    {
        $where = " true ";
        if ($param<>null) {
            if (isset($param)) {
                $where.=" and idProducto ='".$param["idProducto"]."'";
            }
        }
        $objProducto= new Producto();
        $arregloProductos = $objProducto->listar($where);
        return $arregloProductos;
    }
}
