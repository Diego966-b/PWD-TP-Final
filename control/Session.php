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
    public function iniciar($nombreUsuario, $contrasenia)
    {
        $exito = false;
        $obj = new AbmUsuario();
        $param['usNombre'] = $nombreUsuario;
        $param['usPass'] = $contrasenia;
        $param['usDeshabilitado'] = "null";
        $resultado = $obj->buscar($param);
        if (count($resultado) > 0) {
            $usuario = $resultado[0];
            $idUsuario = $usuario->getIdUsuario();
            $_SESSION['idUsuario'] = $idUsuario;
            $exito = true;
        } else {
            $this->cerrar();
        }
        return $exito;
    }

    /**
     * Devuelve un booleano dependiendo de si la sesion esta activa o no.
     * @return boolean
     */
    public function activa()
    {
        $resp = false;
        if (php_sapi_name() !== 'cli') {
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                $resp = session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
            } else {
                $resp = session_id() === '' ? FALSE : TRUE;
            }
        }
        return $resp;
    }

    /**
     * Valida una sesion. Retorna un booleano
     * @return boolean
     */
    public function validar()
    {
        $resp = false;
        if ($this->activa() && isset($_SESSION['idUsuario'])) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * Cierra sesion. Retorna un booleano.
     * @return boolean
     */
    public function cerrar()
    {
        $exito = false;
        if (session_destroy()) {
            $exito = true;
        }
        return $exito;
    }

    /**
     * Devuelve el obj del usuario logeado.
     * Retorna null si no hay usuario logeado.
     */
    public function getUsuario()
    {
        $usuario = null;
        if ($this->validar()) {
            $obj = new AbmUsuario();
            $param['idUsuario'] = $_SESSION['idUsuario'];
            $resultado = $obj->buscar($param);
            if (count($resultado) > 0) {
                $usuario = $resultado[0];
            }
            return $usuario;
        }
    }

    /**
     * Devuelve obj rol o roles del usuario logeado.
     * Retorna null si no hay usuario logeado.
     */
    public function getRol()
    {
        $listaRoles = null;
        if ($this->validar()) {
            $obj = new AbmUsuario();
            $param['idUsuario'] = $_SESSION['idUsuario'];
            $resultado = $obj->darRoles($param);
            // if (count($resultado) > 0)
            // {
            //     $listaRoles = $resultado [0];
            // }
            // return $listaRoles;
            return $resultado;
        }
    }

    /**
     * Agrega un item al carrito que es un arreglo de arreglos en sesion
     * @param array $arregloProducto
     */
    public function agregarItemCarrito($arregloProducto)
    {
        $idProducto = $arregloProducto['idProducto'];
        $proCantidadInicial = $arregloProducto['proCantidad'];
        $proStock = $arregloProducto["proCantStock"];
        $stockFinal = $proStock - $proCantidadInicial;
        if ($stockFinal >= 0) {
            $arregloProducto["proCantStock"] = $stockFinal;
            $arregloProducto["accion"] = "editar";
            $abmProducto = new AbmProducto();
            $resultado = $abmProducto->abm($arregloProducto);
            $arrayCarrito = $this->setearCarrito();
            for ($i = 0; $i < count($arrayCarrito); $i++) {
                $arrayProductoActual = [];
                $arrayProductoActual = $arrayCarrito[$i];
                $idProductoActual = $arrayProductoActual["idProducto"];
                if ($idProductoActual == $idProducto) {
                    $arrayCarrito[$i]["proCantidad"] += $proCantidadInicial;
                    $entre = true;
                }
            }
            if (!$entre) {
                $arrayProducto["idProducto"] = $idProducto;
                $arrayProducto["proCantidad"] = $proCantidadInicial;
                array_push($arrayCarrito, $arrayProducto);
            }
            $_SESSION['carrito'] = $arrayCarrito;
        }
    }

    /**
     * Setea el carrito en la variable $_SESSION
     */
    public function setearCarrito()
    {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = array();
        }
        return $_SESSION['carrito'];
    }

    /**
     * Elimina el carrito
     */
    public function eliminarCarrito()
    {
        $exito = false;
        if (isset($_SESSION['carrito'])) {
            unset($_SESSION["carrito"]);
            $exito = true;
        }
        return $exito;
    }

    /**
     * Elimina 1 unidad del carrito. Si el carrito se queda sin unidades, borra el carrito.
     */
    public function eliminarUnidad($idProducto)
    {
        $resp = false;
        $carrito = $_SESSION['carrito'];
        $nuevoCarrito = array();
        print_r($carrito);
        foreach ($carrito as $arrayProducto) {
            if ($idProducto <> $arrayProducto["idProducto"]) {
                // Agrego el producto al nuevo carrito si no coincide con el ID a eliminar
                array_push($nuevoCarrito, $arrayProducto);
            }
        }
        if (count($nuevoCarrito) == 0) {
            // Borro carrito
            $resp = true;
            $this->eliminarCarrito();
            // unset($_SESSION["carrito"]);
        } else {
            // Actualizo el carrito en la sesión
            $_SESSION["carrito"] = $nuevoCarrito;
            $resp = true;
        }
        return $resp;
    }

    /**
     * Paga el carrito
     */
    public function pagarCarrito($colDatos)
    {
        $abmProducto = new AbmProducto();
        $abmCompra = new AbmCompra();
        $abmCompraEstado = new AbmCompraEstado();
        $abmCompraEstadoTipo = new AbmCompraEstadoTipo();
        $abmCompraItem = new AbmCompraItem();
        $colProductosCarrito = [];
        $arrayConsulta = [];
        $carrito = $colDatos["carrito"];
        $objUsuario = $this->getUsuario();

        // Creo un nuevo Compra

        $arrayConsulta = [];
        $idUsuario = $objUsuario->getIdUsuario();
        $arrayConsulta["idUsuario"] = $idUsuario;
        $arrayConsulta["coFecha"] = date("Y-m-d H:i:s");
        $arrayConsulta["accion"] = "nuevo";
        $resultado = $abmCompra->abm($arrayConsulta);

        $exito = $resultado["exito"];
        if ($exito) {
            $idCompra = $resultado["id"];
        } else {
            $idCompra = "";
        }

        // Creo un nuevo CompraEstado

        $arrayConsultaCE = [];
        $arrayConsultaCE["accion"] = "nuevo";
        $arrayConsultaCE["idCompraEstadoTipo"] = 1; // guardo 1 ya que es el id de la compra iniciada
        $arrayConsultaCE["ceFechaIni"] = date("Y-m-d H:i:s");
        $arrayConsultaCE["ceFechaFin"] = "0000-00-00 00:00:00";
        $arrayConsultaCE["idCompra"] = $idCompra;
        $resultado = $abmCompraEstado->abm($arrayConsultaCE);

        // Creo el CompraItem

        for ($i = 0; $i < count($carrito); $i++) {
            $arrayConsulta = [];
            $arrayProducto = $carrito[$i];
            $idProducto = $arrayProducto["idProducto"];
            $proCantidad = $arrayProducto["proCantidad"];
            // compraItem
            $arrayConsulta["accion"] = "nuevo";
            $arrayConsulta["ciCantidad"] = $proCantidad;
            $arrayConsulta["idProducto"] = $idProducto;
            $arrayConsulta["idCompra"] = $idCompra;
            $abmCompraItem->abm($arrayConsulta);
        }

        $this->eliminarCarrito();
    }


    /**
     * Verifica si el usuario tiene permiso para ingresar a la pagina acutal.
     * Retorna un booleano
     */
    public function tienePermisoB($objUsuario)
    {
        $tienePermiso = false;
        $url = $_SERVER["REQUEST_URI"];
        $array = [];
        $array["idUsuario"] = $objUsuario->getIdUsuario();
        $abmUsuarioRol = new AbmUsuarioRol();
        $listObjUsuarioRol = $abmUsuarioRol->buscar($array);
        foreach ($listObjUsuarioRol as $objUsuarioRol) {
            $objRol = $objUsuarioRol->getObjRol();
            $idRol = $objRol->getIdRol();
            $arrayRol = [];
            $arrayRol["idRol"] = $idRol;
            $abmMenuRol = new AbmMenuRol();
            $listaMenus = $abmMenuRol->buscar($arrayRol);
            foreach ($listaMenus as $objMenuRol) {
                $objMenu = $objMenuRol->getObjMenu();
                $urlMenu = $objMenu->getMeDescripcion();
                $urlMenu = substr($urlMenu, 2);
                if (strpos($url, $urlMenu) <> false) {
                    $tienePermiso = true;
                }
            }
        }

        return $tienePermiso;
    }
    public function estadoMenu()
    {
        $habilitado = false;
        $url = $_SERVER["REQUEST_URI"];
        $ambMenu = new AbmMenu();
        $listaMenus = $ambMenu->buscar(null);
        foreach ($listaMenus as $menu) {
            $urlMenu = $menu->getMeDescripcion();
            $urlMenu = substr($urlMenu, 2);
            if (strpos($url, $urlMenu) <> false && $menu->getMeDeshabilitado() == null) {
                $habilitado = true;
            }
        }
        return $habilitado;
    }
}
