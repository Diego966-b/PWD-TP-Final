<?php

class Session
{
    public function __construct()
    {
        if (!session_start()) {
            return false;
        } else {
            return true;
        }
    }

    public function iniciar($nombreUsuario, $pswUsuario)
    {
        $resp = false;
        if ($this->activa() && $this->validar($nombreUsuario, $pswUsuario)) {
            $_SESSION['usnombre'] = $nombreUsuario;
            $user = $this->getUsuario();
            $_SESSION['idusuario'] = $user->getID();
            $_SESSION['usmail'] = $user->getUsMail();
            $_SESSION['usdeshabilitado'] = $user->getUsDeshabilitado();

            $resp = true;
        }

        if ($resp) {
            $this->setearRolActivo();
        }

        return $resp;
    }

    public function setearRolActivo()
    {
        $verificador=false;
        $rolesUs = $this->getRoles(); // TRAEMOS EL ARREGLO DE OBJETOS

        if (count($rolesUs) > 0) {
            $rolActivoDescripcion=$rolesUs[0]->getRolDescripcion();
            $_SESSION['rolactivodescripcion'] = $rolActivoDescripcion;
            $idRol = $this->buscarIdRol($rolActivoDescripcion);
            $_SESSION['rolactivoid'] = $idRol;
            $verificador = true;
        } else {
            $_SESSION['rolactivodescripcion'] = null;
            $_SESSION['rolactivoid'] = null;
        }
        return $verificador;
    }

    public function buscarIdRol($param)
    {
        $retorno = null;
        $roles = $this->getRoles();
        foreach ($roles as $rol) {
            if ($rol->getRolDescripcion() === $param) {
                $retorno = $rol->getID();
            }
        }

        return $retorno;
    }

    public function activa()
    {
        if (php_sapi_name() !== 'cli') {
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                //compara la version de php para ver si se puede usar el metodo session_status()
                return session_status() === PHP_SESSION_ACTIVE ? true : false;
            } else {
                //si la version es menor se fija comparando el id de la session actual, para ver si esta seteada.

                return session_id() === '' ? false : true;
            }
        }

        return false;
    }

    public function sesionActiva()
    {
        $resp = false;
        if ($this->getNombreUsuarioLogueado() <> null) {
            $resp = true;
        }
        return $resp;
    }

    public function validar($usNombre, $usPsw)
    {
        //Viene por parametro el nombre de usuario y la contraseña encriptada
        $resp = false;
        if ($this->activa()) {
            $objAbmUsuario = new abmUsuario();
            $param = array("usnombre" => $usNombre, 'uspass' => $usPsw);
            $listaUsuario = $objAbmUsuario->buscar($param);
            if (!empty($listaUsuario)) {
                $resp = true;
            }
        }
        return $resp;
    }


    private function getUsuario()
    {
        //Método privado para no devolver el usuario fuera de la clase Session
        $user = null;
        if ($this->activa() && isset($_SESSION['usnombre'])) {
            $objAbmUsuario = new AbmUsuario();
            $param['usnombre'] = $_SESSION['usnombre'];
            $listaUsuario = $objAbmUsuario->buscar($param);
            $user = $listaUsuario[0];
        }
        return $user;
    }

    public function obtenerDeshabilitado($fecha)
    {
        $retorno = false;
        if ($fecha === null || $fecha === '0000-00-00 00:00:00') {
            $retorno = true;
        }
        return $retorno;
    }

    public function getRoles()
    {
        //Devuelve un arreglo con los objetos rol del user
        $roles = [];
        $user = $this->getUsuario();
        if ($user != null) {
            //Primero busco la instancia de UsuarioRol
            $objAbmUsuarioRol = new AbmUsuarioRol();
            //Creo el parametro con el id del usuario
            $parametroUser = array('idusuario' => $user->getID());
            $listaUsuarioRol = $objAbmUsuarioRol->buscar($parametroUser);
            foreach ($listaUsuarioRol as $tupla) {
                array_push($roles, $tupla->getObjRol());
            }
        }
        return $roles;
    }

    public function getNombreUsuarioLogueado()
    {
        //retorna el nombre del usuario logueado
        $nombreUsuario = null;
        if (isset($_SESSION['usnombre'])) {
            $nombreUsuario = $_SESSION['usnombre'];
        }
        return $nombreUsuario;
    }

    public function getIDUsuarioLogueado()
    {
        //retorna el id del usuario logueado
        $nombreUsuario = null;
        if (isset($_SESSION['idusuario'])) {
            $nombreUsuario = $_SESSION['idusuario'];
        }
        return $nombreUsuario;
    }

    public function getMailUsuarioLogueado()
    {
        //retorna el mail del usuario logueado
        $nombreUsuario = null;
        if (isset($_SESSION['usmail'])) {
            $nombreUsuario = $_SESSION['usmail'];
        }
        return $nombreUsuario;
    }

    public function getRolActivo()
    {
        $resp = [];
        if (isset($_SESSION['rolactivodescripcion']) && isset($_SESSION['rolactivoid'])) {
            $resp = [
                'rol' => $_SESSION['rolactivodescripcion'],
                'id' => $_SESSION['rolactivoid']
            ];
        }
        return $resp;
    }


    public function cerrar()
    {
        //Primero me fijo si esta activa la session
        if ($this->activa()) {
            //elimino sus datos
            unset($_SESSION['idusuario']);
            unset($_SESSION['usnombre']);
            unset($_SESSION['usmail']);
            unset($_SESSION['usdeshabilitado']);
            unset($_SESSION['rolactivodescripcion']);
            unset($_SESSION['rolactivoid']);
            //destruyo la session
            session_destroy();
        }
    }

    public function setIdRolActivo($param)
    {
        $_SESSION['rolactivoid'] = $param;
    }

    public function setDescripcionRolActivo($param)
    {
        $_SESSION['rolactivodescripcion'] = $param;
    }


    public function verificarPermiso($param)
    {
        $user = $this->getUsuario();
        $permiso = false;
        if($user!=null){
        if ($this->obtenerDeshabilitado($user->getUsDeshabilitado())) {
            $permiso = $this->recorrerPermisosPorRoles($this->getRoles(), $param); //LE MANDAMOS TODOS LOS ROLES DEL USUARIO
        }
    }

        return $permiso;
    }

    public function recorrerPermisosPorRoles($roles, $script)
    {
        $objMR = new abmMenuRol();
        $recorrido = false;
        foreach ($roles as $rolActual) { // POR CADA ROL OBTENEMOS LOS MENUES Y BUSCAMOS SI EL SCRIPT SE ENCUENTRA AHI
            $listaMR = $objMR->buscar(['idrol' => $rolActual->getID()]);
            $abmMenu = new abmMenu(); // MANDAMOS EL ABM PARA BUSCAR LOS HIJOS EN CASO DE QUE EXISTAN

            $a = 0; //contador
            while (!$recorrido && ($a < count($listaMR))) {
                $recorrido = $this->buscarPermiso($listaMR[$a]->getObjMenu(), $script, $abmMenu);
                $a++;
            }
        }

        return $recorrido;
    }

    public function buscarPermiso($menu, $param, $abm)
    {
        $respuesta2 = false;
        $hijos = $abm->tieneHijos($menu->getID());
        if (!empty($hijos)) { // SI TIENE HIJOS VERIFICAMOS QUE TENGAN EL ACCESO
            $i = 0; //contador
            while (!$respuesta2 && ($i < count($hijos))) {
                if ($hijos[$i]->getMeDescripcion() == $param) { // PUEDE SER PADRE OSEA DESCRIPCION = "#"
                    $respuesta2 = true;
                } else {
                    $respuesta2 = $this->buscarPermiso($hijos[$i], $param, $abm); // HACEMOS RECURSIVIDAD PORQUE ESOS HIJOS PUEDEN TENER HIJOS
                }
                $i++;
            }
        } else {
            if ($menu->getMeDescripcion() == $param) { // EN CASO DE NO TENER HIJOS VERIFICAMOS SI EL PADRE TIENE EL ACCESO
                $respuesta2 = true;
            }
        }

        return $respuesta2;
    }

    public function cambiarRol($datos)
    {
        $resp = false;
        $rolActivo = $this->getRolActivo();

        if ($rolActivo['rol'] <> $datos['nuevorol']) { // SI EL ROL ES DISTINTO AL YA SETEADO HACEMOS EL CAMBIO
            $idRol = $this->buscarIdRol($datos['nuevorol']);
            $this->setIdRolActivo($idRol);
            $this->setDescripcionRolActivo($datos['nuevorol']);
            $resp = true;
        }

        return $resp;
    }
}
