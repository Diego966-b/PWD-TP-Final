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
            if($datos['accion']=='editarEstado')
            {
                if ($this->editarEstado($datos)) {
                    $array ["exito"] = true;
                }
            }
            if($datos['accion']=='actualizarEstado')
            {
                if ($this->actualizarEstado($datos)) {
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
    
    private function actualizarEstado ($data)
    {
        $idCompra = $data['idCompra'];
        $idCompraEstadoTipo = $data['idCompraEstadoTipo'];
        //cargo el ultimo compra estado, como viene uno solo(busca por su id) selecciono el arreglo en posicion 0
        $buscaCompra['idCompraEstado']=$data['idCompraEstado'];
        $compraEstado = new AbmCompraEstado();
        $arrObjCompraEstado = $compraEstado->buscar($buscaCompra);
        $ObjCompraEstado = $arrObjCompraEstado[0];
        // seteo el id de ese objeto CompraEstado (es el mismo que me mando por ajax 'idCompraEstado'), tambien las fechas que tenia este estado
        $idCompraEstado = $ObjCompraEstado->getIdCompraEstado();
        $ceFechaIni = $ObjCompraEstado->getCeFechaIni();
        $ceFechaFin = $ObjCompraEstado->getCeFechaFin();
        // fecha actual
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha_actual = date("Y-m-d H:i:s");
        // seteo el arreglo de datos para las acciones AmbCompraEstado
        $datos['accion'] = "editarEstado";
        $datos['idCompraEstado'] = $idCompraEstado; //id del ultimo estado que tuvo la compra
        $datos['idCompra'] = $idCompra; // id de la compra
        $datos['idCompraEstadoTipo'] = $idCompraEstadoTipo; //id del tipo de estado de la compra
        $datos['ceFechaIni'] = $ceFechaIni; // fecha Inicio estado
        $datos['ceFechaFin'] = $fecha_actual;// fecha Fin estado
    
        $respuesta = $compraEstado->abm($datos);
        $exito = $respuesta["exito"];
        return $exito;
    }


    private function editarEstado($datos)
    {
        $resp = false;
        $idCompraEstado = $datos['idCompraEstado'];
        $idCompra = $datos['idCompra'];
        $idCompraEstadoTipo = $datos['idCompraEstadoTipo'];
        // $ceFechaIni = $datos['ceFechaIni'] ; // no lo usamos
        $fechaFin= $datos['ceFechaFin']; // tecnicamente deberia ser 0000
        //seteo el objeto compraEstado (el ultimo estado que tiene/ estado actual)
        $array['idCompraEstado'] = $idCompraEstado;
        $AbmCompraEstado = new AbmCompraEstado();
        $arregloEstados = $AbmCompraEstado->buscar($array);
        $compraEstado = $arregloEstados[0];

        $array["idCompra"] =$compraEstado->getObjCompra()->getIdCompra();
        $array['idCompraEstadoTipo'] = $compraEstado->getObjCompraEstadoTipo()->getIdCompraEstadoTipo();
        $array['ceFechaIni'] = $compraEstado->getCeFechaIni();
        $array['ceFechaFin'] = $fechaFin;
        print_r($array);
        if($this->modificacion($array)){
            $resp = true; 
            $arrayDatos['idCompra'] = $idCompra;
            $arrayDatos['idCompraEstadoTipo'] =  $idCompraEstadoTipo;
            $arrayDatos['ceFechaIni'] =  $fechaFin;
            $arrayDatos['ceFechaFin'] = '0000-00-00 00:00:00';

            $this->alta($arrayDatos);
        }
       
        return $resp;
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
            print_r($listaCompraEstadoTipo);
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
        $param['idCompraEstado'] = null; 
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