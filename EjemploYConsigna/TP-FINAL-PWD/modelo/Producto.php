<?php
class Producto
{
    private $idProducto;
    private $nombre;
    private $detalle;
    private $cantStock;
    private $proPrecio;
    private $urlImagen;
    private $mensajeFuncion;


    /**************************************/
    /**************** SET *****************/
    /**************************************/

    /**
     * Establece el valor de idProducto
     */
    public function setIdProducto($idProducto)
    {
        $this->idProducto = $idProducto;
    }

    /**
     * Establece el valor de nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Establece el valor de detalle
     */
    public function setDetalle($detalle)
    {
        $this->detalle = $detalle;
    }

    /**
     * Establece el valor de cantStock
     */
    public function setCantStock($cantStock)
    {
        $this->cantStock = $cantStock;
    }


    /**
     * Establece el valor de mensajeFuncion
     */
    public function setMensajeFuncion($mensajeFuncion)
    {
        $this->mensajeFuncion = $mensajeFuncion;
    }

    /**
     * Establece el valor de urlImagen
     */
    public function setUrlImagen($urlImagen)
    {
        $this->urlImagen = $urlImagen;
    }

    /**
     * Establece el valor de proPrecio
     */
    public function setProPrecio($proPrecio)
    {
        $this->proPrecio = $proPrecio;
    }

    /**************************************/
    /**************** GET *****************/
    /**************************************/

    /**
     * Obtiene el valor de idProducto
     */
    public function getIdProducto()
    {
        return $this->idProducto;
    }

    /**
     * Obtiene el valor de nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Obtiene el valor de detalle
     */
    public function getDetalle()
    {
        return $this->detalle;
    }

    /**
     * Obtiene el valor de cantStock
     */
    public function getCantStock()
    {
        return $this->cantStock;
    }

    /**
     * Obtiene el valor de urlImagen
     */
    public function getUrlImagen()
    {
        return $this->urlImagen;
    }

    /**
     * Obtiene el valor de mensajeFuncion
     */
    public function getMensajeFuncion()
    {
        return $this->mensajeFuncion;
    }

    /**
     * Obtiene el valor de proPrecio
     */
    public function getProPrecio()
    {
        return $this->proPrecio;
    }

    /**************************************/
    /************** FUNCIONES *************/
    /**************************************/

    public function __construct()
    {
        $this->idProducto = "";
        $this->nombre = "";
        $this->detalle = "";
        $this->proPrecio = "";
        $this->cantStock = "";
        $this->urlImagen = "";
    }

    public function setear($idProducto, $nombre, $detalle, $cantStock, $proPrecio, $ulrImagen)
    {
        $this->setIdProducto($idProducto);
        $this->setNombre($nombre);
        $this->setDetalle($detalle);
        $this->setCantStock($cantStock);
        $this->setProPrecio($proPrecio);
        $this->setUrlImagen($ulrImagen);
    }

    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $consulta = "INSERT INTO producto (proNombre, proDetalle, proCantStock, proPrecio, urlImagen) VALUES (
        '" . $this->getNombre() . "',
		'" . $this->getDetalle() . "',
		'" . $this->getCantStock() . "',
		'" . $this->getProPrecio() . "',
		'" . $this->getUrlImagen() . "')";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $resp =  true;
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE producto SET idproducto='" . $this->getIdProducto() . "', pronombre='" . $this->getNombre() . "', prodetalle='" . $this->getDetalle() . "', procantstock='" . $this->getCantStock() . "', proprecio='" . $this->getProPrecio() . "', urlimagen='" . $this->getUrlImagen() . "' WHERE idproducto='" . $this->getIdProducto() . "'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeFuncion("Producto->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeFuncion("Producto->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = null;
        if ($this->getIdProducto() != '') {
            $sql = "SELECT * FROM producto WHERE idProducto = " . $this->getIdProducto();
        }
        //echo $sql;
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['idProducto'], $row['proNombre'], $row['proDetalle'], $row['proCantStock'], $row['proPrecio'], $row['urlImagen']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $resp;
    }

    public function listar($condicion = "")
    {
        $arregloProductos = null;
        $base = new BaseDatos();
        $consultaPersona = "SELECT * FROM producto ";
        if ($condicion != "") {
            $consultaPersona = $consultaPersona . ' WHERE ' . $condicion;
        }
        $consultaPersona .= " ORDER BY idproducto ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPersona)) {
                $arregloProductos = array();
                while ($Producto = $base->Registro()) {
                    $objProducto = new Producto();
                    $objProducto->setear($Producto['idProducto'], $Producto['proNombre'], $Producto['proDetalle'], $Producto['proCantStock'], $Producto['proPrecio'], $Producto['urlImagen']);
                    array_push($arregloProductos, $objProducto);
                }
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $arregloProductos;
    }

    public function eliminar()
    {
        $base = new BaseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consulta = "DELETE FROM producto WHERE idProducto = '" . $this->getIdProducto() . "'";
            if ($base->Ejecutar($consulta)) {
                $resp =  true;
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $resp;
    }
}
