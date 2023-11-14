<?php
class Producto
{
    // Atributos

    private $idProducto, $proNombre, $proDetalle, $proCantStock, $proImagen, $proPrecio, $proDeshabilitado, $mensajeOperacion;

    // Constructor y setear 

    public function __construct ()
    {
        $this -> idProducto = "";
        $this -> proNombre = "";
        $this -> proDetalle = "";
        $this -> proCantStock = "";
        $this -> proImagen = "";
        $this -> proPrecio = "";
        $this -> proDeshabilitado = "";
        $this -> mensajeOperacion = "";
    }

    public function setear ($idProducto, $proNombre, $proDetalle, $proCantStock, $proImagen, $proPrecio, $proDeshabilitado)
    {
        $this->setIdProducto($idProducto);
        $this->setProNombre($proNombre);
        $this->setProDetalle($proDetalle);
        $this->setProCantStock($proCantStock);
        $this->setProImagen($proImagen);
        $this->setProPrecio($proPrecio);
        $this->setProDeshabilitado($proDeshabilitado);
    }

    // Gets

    public function getIdProducto() { return $this->idProducto; }
    public function getProNombre() { return $this->proNombre; }
    public function getProDetalle() { return $this->proDetalle; }
    public function getProCantStock() { return $this->proCantStock; }
    public function getProImagen() { return $this->proImagen; }
    public function getProPrecio() { return $this->proPrecio; }
    public function getProDeshabilitado() { return $this->proDeshabilitado; }
    public function getMensajeOperacion() { return $this->mensajeOperacion; }
    
    
    // Sets

    public function setIdProducto($idProductoNuevo) { $this->idProducto = $idProductoNuevo; }
    public function setProNombre($proNombreNuevo) { $this->proNombre = $proNombreNuevo; }
    public function setProDetalle($proDetalleNuevo) { $this->proDetalle = $proDetalleNuevo; }
    public function setProCantStock($proCantStockNuevo) { $this->proCantStock = $proCantStockNuevo; }
    public function setProImagen($proImagenNuevo) { $this->proImagen = $proImagenNuevo; }
    public function setProPrecio($proPrecioNuevo) { $this->proPrecio = $proPrecioNuevo;}
    public function setProDeshabilitado($proDeshabilitadoNuevo) { $this->proDeshabilitado = $proDeshabilitadoNuevo; }
    public function setMensajeOperacion($mensajeOperacionNuevo) { $this->mensajeOperacion = $mensajeOperacionNuevo; }
    
    // Metodos

    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = 
        "SELECT * FROM producto WHERE idProducto = " . $this->getIdProducto();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $idProducto = $row['idProducto'];
                    $proNombre = $row['proNombre'];
                    $proDetalle = $row['proDetalle'];
                    $proCantStock = $row['proCantStock'];
                    $proImagen = $row['proImagen'];
                    $proPrecio = $row['proPrecio'];
                    $proDeshabilitado = $row['proDeshabilitado'];
                    $this->setear($idProducto, $proNombre, $proDetalle, $proCantStock, $proImagen, $proPrecio, $proDeshabilitado);
                }
            }
        } else {
            $this->setmensajeoperacion("producto->listar: " . $base->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        // no paso el id por que es autoIncrement
        $sql = 
        "INSERT INTO producto (proNombre, proDetalle, proCantStock, proImagen, proPrecio, proDeshabilitado)  
        VALUES
        ('" . $this->getProNombre() . "','" . $this->getProDetalle() . "','" . 
        $this->getProCantStock()."','". $this->getProImagen() ."','".$this->getProPrecio() . "', NULL);";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("producto->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("producto->insertar: " . $base->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = 
        "UPDATE producto SET 
            proNombre='" . $this->getProNombre() . "',
            proDetalle='" . $this->getProDetalle()."',
            proCantStock='" . $this->getProCantStock()."',
            proImagen='" . $this->getProImagen()."',
            proPrecio='" . $this->getProPrecio()."'
        WHERE idProducto='" . $this->getIdProducto() . "'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("producto->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("producto->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = 
        "DELETE FROM producto WHERE idProducto=" . $this->getIdProducto();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("producto->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("producto->eliminar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminarLogico(){
        $resp = false;
        $base = new BaseDatos();
        $sql = 
        "UPDATE producto SET proDeshabilitado = NOW() WHERE idProducto='" . $this->getIdProducto() . "'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("producto->eliminarLogico: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("producto->eliminarLogico: " . $base->getError());
        }
        return $resp;
    }

    public function activarProducto (){
        $resp = false;
        $base = new BaseDatos();
        $sql = 
        "UPDATE producto SET proDeshabilitado = null WHERE idProducto='" . $this->getIdProducto() . "'"; // VER!!!
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("producto->eliminarLogico: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("producto->eliminarLogico: " . $base->getError());
        }
        return $resp;
    }

    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM producto ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new Producto();

                    $idProducto = $row['idProducto'];
                    $proNombre = $row['proNombre'];
                    $proDetalle = $row['proDetalle'];
                    $proCantStock = $row['proCantStock'];
                    $proImagen = $row['proImagen'];
                    $proPrecio = $row['proPrecio'];
                    $proDeshabilitado = $row['proDeshabilitado'];
                    $obj->setear($idProducto, $proNombre, $proDetalle, $proCantStock, $proImagen, $proPrecio, $proDeshabilitado);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            //$this->setmensajeoperacion("usuario->listar: " . $base->getError());
        }
        return $arreglo;
    }

    public function __toString()
    {
        $frase =
            "<br>El Id del Producto es: " . $this->getIdProducto() .
            ".<br>El nombre es: " . $this->getProNombre() .
            ".<br>Los detalles son: " . $this->getProDetalle() .
            ".<br>El precio es: " . $this->getPrecio() .
            ".<br>La imagen es: " . $this->getImagen() .
            ".<br>Esta deshabilitado: " . $this->getProDeshabilitado() .
            ".<br>La cant de stock es: " . $this->getProCantStock()."<br>";
        return $frase;
    }
}
?>