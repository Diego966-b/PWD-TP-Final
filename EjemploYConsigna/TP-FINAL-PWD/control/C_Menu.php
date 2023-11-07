<?php
class C_Menu{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto

    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Menu
     */
    private function cargarObjeto($param){
        
        $obj = null;
           
        if(array_key_exists('meNombre',$param) and array_key_exists('meDescripcion',$param)){
            
            $obj = new Menu();
            
            $objMenu = null;
            if ($param['idPadre']!=''){
                $objMenu = new Menu();
                $objMenu->setIdMenu($param['idPadre']);
                $objMenu->cargar();
            }
            
            if(!isset($param['meDeshabilitado'])){
                $param['meDeshabilitado']=null;
            }else{
                $param['meDeshabilitado']= date("Y-m-d H:i:s");
            }
            $obj->setear($param['idMenu'],$param['meNombre'],$param['meDescripcion'],$objMenu,$param['meDeshabilitado']); 
        }
        return $obj;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Menu
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
        $resp=false;
        $param['idMenu'] = null; 
        $objMenu=$this->cargarObjeto($param);
        if($objMenu!=null and $objMenu->insertar()){
            if($this->altaRol($objMenu,$param)){
                $resp=true;
            }
        }
      return $resp;
    }

    public function altaRol($objMenu,$param){
        $resp=false;
        $param['idMenu']=$objMenu->getIdMenu();
        $objMenuRol=new C_MenuRol();
        $menuRol=$objMenuRol->cargarObjeto($param);
        if($menuRol!=null && $menuRol->insertar()){
            $resp=true;
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
            $objMenu = $this->cargarObjetoConClave($param);
            if ($objMenu!=null and $objMenu->eliminar()){
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
            $objMenu = $this->cargarObjeto($param);
            if($objMenu !=null and $objMenu ->modificar()){
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
    public function buscar($param){
        $where = " true ";
        if ($param != null){
            if  (isset($param['idMenu']))
                $where.=" and idMenu =".$param['idMenu'];
        }

        $objMenu = new Menu();
        $arreglo = $objMenu->listar($where);  
        return $arreglo; 
    }

    public function deshabilitar($param){
        $resp = false;
        $arrayMenues = $this->buscar($param);
        $fecha = new DateTime();
        $fechaStamp = $fecha->format('Y-m-d H:i:s');
        $objMenu = $arrayMenues[0];
        $objMenu->setMeDeshabilitado($fechaStamp);
        if ($objMenu != null and $objMenu->modificar()) {
            $resp = true;
        }
        return $resp;
    }

    public function habilitar($param){
        $resp = false;
        $arrayObjMenues = $this->buscar($param);
        $objMenu = $arrayObjMenues[0];
        $objMenu->setMeDeshabilitado('habilitar');
        if ($objMenu!= null and $objMenu->modificar()) {
            $resp = true;
        }
        return $resp;
    }
   
}
?>