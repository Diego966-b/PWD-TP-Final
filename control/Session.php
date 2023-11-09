<?php
/*
Implementar dentro de la capa de Control la clase Session con los siguientes métodos:
• _ _construct(). Constructor que. Inicia la sesión.
• iniciar($nombreUsuario,$psw). Actualiza las variables de sesión con los valores ingresados.
• validar(). Valida si la sesión actual tiene usuario y psw  válidos. Devuelve true o false.
• activa(). Devuelve true o false si la sesión está activa o no. 
• getUsuario().Devuelve el usuario logeado.
• getRol(). Devuelve el rol del usuario  logeado.
• cerrar(). Cierra la sesión actual.
*/
class Session
{

    // Métodos 
    
    /**
     * Hace un session_start. 
     */
    public function __construct()
    {
        session_start();
    }

    /**
     * Guarda el ID de usuario en $_SESSION y retorna un booleano.
     * @param string $nombreUsuario
     * @param $contrasenia
     * @return boolean
     */
    public function iniciar ($nombreUsuario, $contrasenia)
    {  
        $exito = false;
        $obj = new AbmUsuario();
        $param['usNombre'] = $nombreUsuario;
        $param['usPass'] = $contrasenia;
        $param['usDeshabilitado'] = "null"; 
        $resultado = $obj -> buscar ($param);
        if (count($resultado) > 0)
        {
            $usuario = $resultado[0];
            $idUsuario = $usuario -> getIdUsuario();
            $_SESSION ['idUsuario'] = $idUsuario;
            $exito = true;
        }
        else
        {
            $this -> cerrar();
        }
        return $exito;
    }

    /**
     * Devuelve un booleano dependiendo de si la sesion esta activa o no.
     * @return boolean
     */
    public function activa ()
    {
        $resp = false;
        if (php_sapi_name() !== 'cli')
        {
            if (version_compare(phpversion(), '5.4.0', '>=')) 
            {
                $resp = session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
            }
            else
            {
                $resp = session_id() === '' ? FALSE : TRUE;
            }
        }
        return $resp;
    }
    
    /**
     * Valida una sesion. Retorna un booleano
     * @return boolean
     */
    public function validar(){
        $resp = false;
        if ($this -> activa() && isset($_SESSION['idUsuario']))
        {
            $resp = true;
        }
        return $resp;
    }

    /**
     * Cierra sesion. Retorna un booleano.
     * @return boolean
     */
    public function cerrar ()
    {
        $exito = false;
        if (session_destroy())
        {
            $exito = true;
        }
        return $exito;
    }

    /**
     * Devuelve el obj del usuario logeado.
     * Retorna null si no hay usuario logeado.
     */
    public function getUsuario(){
        $usuario = null;
        if ($this -> validar())
        {
            $obj = new AbmUsuario();
            $param ['idUsuario'] = $_SESSION['idUsuario'];
            $resultado = $obj -> buscar ($param);
            if (count($resultado) > 0)
            {
                $usuario = $resultado[0];
            }
            return $usuario;
        }
    }

    /**
     * Devuelve obj rol o roles del usuario logeado.
     * Retorna null si no hay usuario logeado.
     */
    public function getRol(){
        $listaRoles = null;
        if ($this -> validar())
        {
            $obj = new AbmUsuario();
            $param ['idUsuario'] = $_SESSION ['idUsuario'];
            $resultado = $obj -> darRoles ($param);
            if (count($resultado) > 0)
            {
                $listaRoles = $resultado [0];
            }
            return $listaRoles;
        }
    }

    /**
     * 
     */
    public function tienePermiso ($idRolIngresado)
    {
        $tienePermiso = false;
        $objSession = new Session();
        $listaRoles = $objSession -> getRol();
        $idRol = $listaRoles -> getObjRol() -> getIdRol();
        if (($listaRoles <> null) && ($idRol == $idRolIngresado))
        {
            $tienePermiso = true;
        }
        return $tienePermiso;
    }   
}