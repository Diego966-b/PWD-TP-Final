<?php
class CompraItem
{
    // Atributos

    private $idCompraItem, $objProducto, $objCompra, $ciCantidad, $mensajeOperacion;

    // Constructor y setear

    public function __construct()
    {
        $this -> idCompraItem = "";
        $this -> ciCantidad = "";
        $this -> objProducto = new Producto();
        $this -> objCompra = new Compra();
    }

    public function setear($idCompraItem, $ciCantidad, $objProducto, $objCompra)
    {
        $this -> setIdCompraitem ($idCompraItem);
        $this -> setCiCantidad ($ciCantidad);
        $this -> setObjProducto($objProducto);
        $this -> setObjCompra($objCompra);
    }

    // Gets

    public function getIdCompraItem() { return $this->idCompraItem; }
    public function getObjProducto() { return $this->objProducto; }
    public function getObjCompra() { return $this->objCompra; }
    public function getCiCantidad() { return $this->ciCantidad; }
    public function getMensajeOperacion() { return $this->mensajeOperacion; }

    // Sets

    public function setIdCompraItem($idCompraItemNuevo) { $this->idCompraItem = $idCompraItemNuevo; }
    public function setObjProducto($objProductoNuevo) { $this->objProducto = $objProductoNuevo; }
    public function setObjCompra($objCompraNuevo) { $this->objCompra = $objCompraNuevo; }
    public function setCiCantidad($ciCantidadNuevo) { $this->ciCantidad = $ciCantidadNuevo; }
    public function setMensajeOperacion($mensajeOperacionNuevo) { $this->mensajeOperacion = $mensajeOperacionNuevo; }

    // Metodos

    public function cargar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = 
        "SELECT * FROM compraItem WHERE idCompraItem = " . $this->getIdCompraItem();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $abmProducto = new AbmProducto();
                    $abmCompra = new AbmCompra();
                    $array = [];
                    $array ['idProducto'] = $row['idProducto'];
                    $array ['idCompra'] = $row['idCompra'];
                    $listaProductos = $abmProducto -> buscar ($array);
                    $listaCompras = $abmCompra -> buscar ($array);
                    $objProducto = $listaProductos[0];
                    $objCompra = $listaCompras[0];
                    $idCompraItem = $row['idCompraItem'];
                    $ciCantidad = $row['ciCantidad'];

                    $this->setear($idCompraItem, $ciCantidad, $objProducto, $objCompra);
                }
            }
        } else {
            $this->setMensajeOperacion("compraItem->listar: " . $base->getError());
        }
        return $respuesta;
    }

    public function insertar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $objProductoDeVerdad = $this->getObjProducto();
        $objCompraDeVerdad = $this->getObjCompra();
        $sql = 
        "INSERT INTO compraItem (idCompraItem, ciCantidad, idProducto, idCompra)
            VALUES ('" . 
            $this->getIdCompraItem() . "', '" . 
            $this->getCiCantidad() . "', '" . 
            $objProductoDeVerdad->getIdProducto() . "', '" . 
            $objCompraDeVerdad->getIdCompra() . "')";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("compraItem->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraItem->modificar: " . $base->getError());
        }
        return $respuesta;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $objProductoDeVerdad = $this->getObjProducto();
        $objCompraDeVerdad = $this->getObjCompra();
        $sql = 
        "UPDATE compraItem SET 
            ciCantidad='" . $this->getCiCantidad() . "',
            idProducto='" . $objProductoDeVerdad->getIdProducto() . "',
            idCompra='" . $objCompraDeVerdad->getIdCompra() . "'
        WHERE idCompraItem='" . $this->getIdCompraItem() . "'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("compraItem->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("compraItem->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compraItem WHERE idCompraItem = " . $this->getIdCompraItem();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("compraItem->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraItem->eliminar: " . $base->getError());
        }
        return $respuesta;
    }

    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos;
        $sql = "SELECT * FROM compraItem ";
        if ($parametro != "") {
            $sql .= "WHERE " . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $abmProducto = new AbmProducto();
                    $abmCompra = new AbmCompra();
                    $obj = new CompraItem();
                    $array = [];
                    $array ['idProducto'] = $row['idProducto'];
                    $array ['idCompra'] = $row['idCompra'];
                    $listaProductos = $abmProducto -> buscar ($array);
                    $listaCompras = $abmCompra -> buscar ($array);
                    $objProducto = $listaProductos[0];
                    $objCompra = $listaCompras[0];
                    $idCompraItem = $row['idCompraItem'];
                    $ciCantidad = $row['ciCantidad'];
                    $obj->setear($idCompraItem, $ciCantidad, $objProducto, $objCompra);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            //$this->setMensajeoperacion("usuarioRol->listar: " . $base->getError());
        }
        return $arreglo;
    }

    public function __toString()
    {
        $objCompra = $this -> getObjCompra();
        $objProducto = $this -> getObjProducto();
        $frase =
            "<br>El id de la CompraItem es: " . $this->getIdCompraItem() .
            "<br>El ciCantidad es: " . $this->getCiCantidad() .
            "<br>El id compra es: " . $objCompra -> getIdCompra() .
            "<br>El id producto es: " . $objProducto-> getIdProducto() ."<br>";
        return $frase;
    }
}
?>