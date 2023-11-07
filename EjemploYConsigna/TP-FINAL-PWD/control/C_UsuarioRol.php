<?php

class C_UsuarioRol
{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto


    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */

    private function cargarObjeto($param)
    {
        //verEstructura($param);
        $objUsuarioRol = null;
        $objRol = null;
        $objUsuario = null;
        //print_r($param);
        if (array_key_exists('idRol', $param) && array_key_exists('idUsuario', $param)) {
            $objRol = new Rol();
            $objRol->setIdRol($param['idRol']);
            $objUsuario = new Usuario();
            $objUsuario->setIdUsuario($param['idUsuario']);
            $objUsuarioRol = new UsuarioRol();
            $objUsuarioRol->setear($objUsuario, $objRol);
        }
        return $objUsuarioRol;
    }
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return object
     */
    private function cargarObjetoConClave($param)
    {
        $objUsuarioRol = null;
        //print_R ($param);
        if (isset($param['idUsuario']) && isset($param['idRol'])) {
            $objUsuarioRol = new UsuarioRol();
            $objUsuarioRol->setear($param['idUsuario'], $$param['idRol']);
        }
        return $objUsuarioRol;
    }


    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */

    private function seteadosCamposClaves($param)
    {

        $resp = false;
        if (isset($param['idUsuario']) && isset($param['idRol']));
        $resp = true;
        return $resp;
    }

    /**
     *
     * @param array $param
     */
    public function alta($param)
    {
        //  echo "entramos a alta";
        $resp = false;
        $objUsuarioRol = $this->cargarObjeto($param);
        // verEstructura($elObjtAuto);
        //print_r($objUsuarioRol);
        if ($objUsuarioRol != null) {
            if ($objUsuarioRol->insertar()) {
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

    public function baja($param)
    {
        //verEstructura($param);
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objUsuarioRol = $this->cargarObjetoConClave($param);
            if ($objUsuarioRol != null and $objUsuarioRol->eliminar()) {
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
        //print_R($param);
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objUsuarioRol = $this->cargarObjeto($param);
            if ($objUsuarioRol != null and $objUsuarioRol->modificar()) {
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

    public function buscar($param)
    {
        // print_R ($param);

        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idUsuario']))
                $where .= " and idUsuario='" . $param['idUsuario'] . "'";
            if (isset($param['idRol']))
                $where .= " and idRol ='" . $param['idRol'] . "'";
        }
        $arreglo = UsuarioRol::listar($where, "");
        return $arreglo;
    }

    //esta funcion me devuelve un array de descripcion de roles de un array de usuarios:
    public function darDescripcionRoles($arrayUsuarios){
        $rolesUs = [];
        foreach ($arrayUsuarios as $us) {
            $param['idUsuario'] = $us->getIdUsuario();
            array_push($rolesUs, $this->buscar($param)); //esto me devuelve un array de objetos usuario +rol
        }
        $rolesDesc = [];
        foreach ($rolesUs as $rolUs) {
            $roles = [];
            //aca me devuelve el array de roles de cada usuario:
            foreach ($rolUs as $rolU) {
                $rol = $rolU->getRol()->getRolDescripcion();
                array_push($roles, $rol);
            }
            array_push($rolesDesc, $roles);
        }
        return $rolesDesc;
    }

    public function darIdRoles($arrayUsuarios){
        $rolesUs = [];
        foreach ($arrayUsuarios as $us) {
            $param['idUsuario'] = $us->getIdUsuario();
            array_push($rolesUs, $this->buscar($param)); //esto me devuelve un array de objetos usuario +rol
        }
        $rolesId = [];
        foreach ($rolesUs as $rolUs) {
            $roles = [];
            //aca me devuelve el array de roles de cada usuario:
            foreach ($rolUs as $rolU) {
                $rol = $rolU->getRol()->getIdRol();
                array_push($roles, $rol);
            }
            array_push($rolesId, $roles);
        }
        return $rolesId;
    }
}
