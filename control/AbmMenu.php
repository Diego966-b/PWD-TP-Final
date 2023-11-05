<?php
class AbmMenu{
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Tabla
     */
    private function cargarObjeto($param){
        $obj = null;
        if (array_key_exists('idMenu',$param) and array_key_exists('meNombre',$param)){
            $obj = new Menu();
            $objmenu = null;
            if (isset($param['idPadre'])){
                $objmenu = new Menu();
                $objmenu->setIdmenu($param['idPadre']);
                $objmenu->cargar();
            }
            if(!isset($param['meDeshabilitado'])){
                $param['meDeshabilitado']=null;
            }else{
                $param['meDeshabilitado']= date("Y-m-d H:i:s");
            }
            $obj->setear($param['idMenu'], $param['meNombre'],$param['meDescripcion'],$objmenu,$param['meDeshabilitado']); 
        }
        return $obj;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Tabla
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if( isset($param['idMenu']) ){
            $obj = new Menu();
            $obj->setIdmenu($param['idMenu']);
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
        if (isset($param['idMenu']))
            $resp = true;
        return $resp;
    }
    
    /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $param['idMenu'] =null;
        $param['meDeshabilitado'] = null;
        $elObjtTabla = $this->cargarObjeto($param);
        if ($elObjtTabla!=null and $elObjtTabla->insertar()){
            $resp = true;
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
        if ($this->seteadosCamposClaves($param)){
            $elObjtTabla = $this->cargarObjetoConClave($param);
            if ($elObjtTabla!=null and $elObjtTabla->eliminar()){
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
    public function modificacion($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtMenu = $this->cargarObjeto($param);
            if($elObjtMenu!=null and $elObjtMenu->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    /**
     * permite buscar un objeto
     * @param array $param
     * @return boolean
     */
    public function buscar($param){
        $where = " true ";
        /*if ($param<>NULL){
            if  (isset($param['id']))
                $where.=" and id =".$param['id'];
            if  (isset($param['descrip']))
                 $where.=" and descrip ='".$param['descrip']."'";
        }*/
        $arreglo = Menu::listar($where);  
        return $arreglo;
    }
}
?>