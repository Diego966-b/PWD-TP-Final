<?php
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
     * Agrega un item al carrito que es un arreglo de arreglos en sesion
     * @param array $arregloProducto
     */
    public function agregarItemCarrito ($arregloProducto)
    {
        $idProducto = $arregloProducto['idProducto'];
        $proCantidadInicial = $arregloProducto['proCantidad'];
        $proStock = $arregloProducto["proCantStock"];
        $stockFinal = $proStock - $proCantidadInicial;
        if ($stockFinal >= 0)
        {
            $arregloProducto ["proCantStock"] = $stockFinal;
            $arregloProducto ["accion"] = "editar";
            $abmProducto = new AbmProducto();
            $resultado = $abmProducto -> abm($arregloProducto);
            $arrayCarrito = $this -> setearCarrito();
            for ($i = 0; $i < count($arrayCarrito); $i++)
            {
                $arrayProductoActual = [];
                $arrayProductoActual = $arrayCarrito [$i];
                $idProductoActual = $arrayProductoActual ["idProducto"];
                if ($idProductoActual == $idProducto)
                {
                    $arrayCarrito[$i]["proCantidad"] += $proCantidadInicial;
                    $entre = true;
                }
            }
            if (!$entre)
            {
                $arrayProducto ["idProducto"] = $idProducto;
                $arrayProducto ["proCantidad"] = $proCantidadInicial;
                array_push($arrayCarrito, $arrayProducto);
            }
            $_SESSION['carrito'] = $arrayCarrito;
        }
    }

    /**
     * Setea el carrito en la variable $_SESSION
     */
    public function setearCarrito ()
    {   
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = array();
        }
        return $_SESSION['carrito'];
    }

    /**
     * Elimina el carrito
     */
    public function eliminarCarrito ()
    {
        $exito = false;
        if (isset($_SESSION['carrito'])) {
            unset($_SESSION["carrito"]);
            $exito = true;
        }
        return $exito;
    }

    /**
     * Verifica si el usuario tiene permiso para ingresar a la pagina acutal.
     * Retorna un booleano
     */
    public function tienePermisoB ($objUsuario)
    {
        $tienePermiso = false;
        $url = $_SERVER["REQUEST_URI"];

        $array = [];
        $array ["idUsuario"] = $objUsuario -> getIdUsuario();
        $abmUsuarioRol = new AbmUsuarioRol ();
        $objUsuarioRol = $abmUsuarioRol -> buscar($array);
        $objUsuarioRol = $objUsuarioRol [0];
    
        $objRol = $objUsuarioRol -> getObjRol();
        $idRol = $objRol -> getIdRol();
        $arrayRol = [];
        $arrayRol ["idRol"] = $idRol;
        
        $abmMenuRol = new AbmMenuRol();
        $listaMenus = $abmMenuRol -> buscar($arrayRol);
        foreach ($listaMenus as $objMenuRol)
        {
            $objMenu = $objMenuRol -> getObjMenu();
            $urlMenu = $objMenu -> getMeDescripcion();
            $urlMenu = substr($urlMenu , 2);
            if (strpos($url, $urlMenu) <> false)
            {
                $tienePermiso = true;
            }
        }
        return $tienePermiso;
    }   
}