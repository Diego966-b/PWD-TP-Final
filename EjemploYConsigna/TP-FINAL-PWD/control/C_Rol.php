<?php
class C_Rol
{

    private function cargarObjeto($param)
    {
        $obj = null;
        if (array_key_exists('idRol', $param) and array_key_exists('rolDescripcion', $param)) {

            $obj = new Rol();
            $obj->cargar(
                $param['idRol'],
                $param['rolDescripcion'],
            );
        }
        return $obj;
    }

    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idRol'])) {
            $obj = new Rol();
            $obj->setear($param['idRol'], null);
        }
        return $obj;
    }


    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idRol'])) {
            $resp = true;
            return $resp;
        }
    }

    public function alta($param)
    {
        $resp = false;
        $param['idRol'] = null;  // Se comenta ya que esta line es para cuando la base de datos tiene su clave principal Usuario incrementable
        $objRol = $this->cargarObjeto($param);
        if ($objRol != null && $objRol->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objRol = $this->cargarObjetoConClave($param);
            if ($objRol != null && $objRol->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function modificacion($param)
    {
        //echo "Estoy en modificacion";
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objRol = $this->cargarObjeto($param);
            if ($objRol != null and $objRol->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function buscar($param){
        $where = "true";
        if ($param <> NULL) {
            if (isset($param['idRol']))
                $where .= " and idRol=" . $param['idRol'];
            if (isset($param['rolDescripcion']))
                $where .= " and rolDescripcion='" . $param['rolDescripcion'] . "'";
        }
        $objRol = new Rol();
        $arreglo = $objRol->listar($where);
        return $arreglo;
    }

    public function obtenerObj($arrayId){
        $objRoles=[];
        foreach($arrayId as $idRol){
            $param['idRol']=$idRol;
            $objRol=$this->buscar($param);
            array_push($objRoles,$objRol[0]);
        }
        return $objRoles;
    }
    
}