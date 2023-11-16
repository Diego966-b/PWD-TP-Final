<?php
class AbmMenu{
    
    // Metodos

    /**
     * Funcion ABM. Espera un array de parametro. Indicando la accion a realizar.
     * Retorna un array con un mensaje y un booleano segun su exito.
     * @param array $datos
     * @return boolean
     */
    public function abm($datos)
    {
        $resp = false;
        if ($datos['accion'] == 'borrar') {
            if ($this->bajaLogica($datos)) {
                $resp = true;
            }
        }
        if ($datos['accion'] == 'editar') {
            if ($this->modificacion($datos)) {
                $resp = true;
            }
        }
        if ($datos['accion'] == 'alta') {
            if ($this->altaLogica($datos)) {
                $resp = true;
            }
        }
        if ($datos['accion'] == 'nuevo') {
            if ($this->alta($datos)) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Menu
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
        $resp = false;
        $param['idMenu'] =null;
        $param['meDeshabilitado'] = null;
        $elObjtMenu = $this->cargarObjeto($param);
        if ($elObjtMenu!=null and $elObjtMenu->insertar()){
            $resp = true;
        }
      return $resp;
     
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
            $objMenu = $this->buscar($param);
            $menu=$objMenu[0];
            if($menu->activarMenu()){
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
            $objMenu = $this->buscar($param);
            $menu=$objMenu[0];
            if( $menu->eliminarLogico()){
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
     * @return array
     */
    public function buscar($param){
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['idMenu']))
                $where.=" and idMenu =".$param['idMenu'];
        }
        $arreglo = Menu::listar($where);  
        return $arreglo;
    }
}
?>