<?php
class AbmCompra
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
            if($datos['accion']=='bajaCompra') 
            {
                if ($this->bajaCompra($datos)) 
                {
                    $array ["exito"] = true;
                }
            }
            if ($datos['accion'] == 'nuevo') {
                $id = $this->alta($datos);
                if ($id <> null) {
                    $array["exito"] = true;
                    $array["id"] = $id;
                    echo "el id de la compra es ".$id;
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
        if ((array_key_exists('idCompra',$param) && array_key_exists('coFecha',$param) &&
            array_key_exists('idUsuario',$param)))
        {
            $obj = new Compra();
            $abmUsuario = new AbmUsuario();
            $array = [];
            $array ['idUsuario'] = $param['idUsuario'];
            $listaUsuarios = $abmUsuario -> buscar($array);
            $objUsuario = $listaUsuarios [0];
            $idCompra = $param ['idCompra'];
            $coFecha = $param ['coFecha'];
            $obj -> setear ($idCompra, $coFecha, $objUsuario);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves.
     * @param array $param
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        if (isset($param['idCompra'])) {
            $obj = new Compra();
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
        if (isset($param['idCompra']))
            $resp = true;
        return $resp;
    }
    
    /**
     * Carga un compra a la BD. Espera un array como parametro.
     * Retorna un booleano
     * @param array $param
     */
    public function alta($param){
        //$resp = false;
        $param['idCompra'] = null; 
        $idCompraInsertada = null;
        $elObjCompra = $this->cargarObjeto($param);
        if ($elObjCompra != null and (($ultimoId=$elObjCompra->insertar()) <> null)){
            echo "ultimoID".$ultimoId;
            //$resp = true;
        }
        return $ultimoId;
    }

    /**
     * Borra un compra de la BD. Espera un array como parametro.
     * Retorna un booleano.
     * @param array $param
     * @return boolean
     */
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjCompra = $this->cargarObjetoConClave($param); 
            if ($elObjCompra!=null and $elObjCompra->eliminar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    /**
     * Modifica un compra. Espera un array como parametro.
     * Retorna un booleano.
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjCompra = $this->cargarObjeto($param);
            if($elObjCompra!=null and $elObjCompra->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    public function bajaCompra($data)
    {
        $objAbmCompraEstado = new AbmCompraEstado();
        $objAmbCompraItem = new AbmCompraItem();
        $objAbmCompra = new AbmCompra();
        $idCompra = $data['idCompra'];
        $listarCompraEstado = $objAbmCompraEstado->buscar(null);
        foreach($listarCompraEstado as $compraEstado){
            $idCompraActual = $compraEstado->getObjCompra()->getIdCompra();
            if($idCompra == $idCompraActual){
                $arrayBorrar = [];
                $arrayBorrar['idCompraEstado'] = $compraEstado->getIdCompraEstado();
                $arrayBorrar['accion'] = "borrar";
                $objAbmCompraEstado->abm($arrayBorrar);
            }
        }
    
        $listaObjCompraItem = $objAmbCompraItem->buscar(null);
    
        foreach ($listaObjCompraItem as $objCompraItem){
            $idCompraActual = $objCompraItem->getObjCompra()->getIdCompra();
            if($idCompra == $idCompraActual){
                $arrayBorrar2['idCompraItem'] = $objCompraItem->getIdCompraItem();
                $arrayBorrar2['accion'] = "borrar";
                $objAmbCompraItem->abm($arrayBorrar2);            
            }
        }
    
        $arregloCompras = $objAbmCompra->buscar($data);
        $objCompra = $arregloCompras[0];
        $array['idCompra'] = $objCompra->getIdCompra();
        $array['accion'] = "borrar";
        $respuesta=$objAbmCompra->abm($array);
        $exito = $respuesta ["exito"];
        return $exito;
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
            if  (isset($param['idCompra'])) {
                $where.=" and idCompra=".$param['idCompra'];
            }
            if  (isset($param['coFecha'])) {
                $where.=" and coFecha ='".$param['coFecha']."'";
            }
            if  (isset($param['idUsuario'])) {
                $where.=" and idUsuario=".$param['idUsuario'];
            }
        }
        $arreglo = Compra::listar($where);
        return $arreglo;  
    }
}
?>