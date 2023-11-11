<?php
class Producto
{
    // Atributos

    private $idProducto, $proNombre, $proDetalle, $imagen, $proCantStock, $mensajeOperacion;

    // Constructor y setear 

    public function __construct ()
    {
        $this -> idProducto = "";
        $this -> proNombre = "";
        $this -> proDetalle = "";
        $this-> imagen = "";
        $this -> proCantStock = "";
        $this -> mensajeOperacion = "";
    }

    public function setear ($idProducto, $proNombre, $proDetalle, $imagen, $proCantStock)
    {
        $this->setIdProducto($idProducto);
        $this->setProNombre($proNombre);
        $this->setProDetalle($proDetalle);
        $this->setImagen($imagen);
        $this->setProCantStock($proCantStock);
    }

    // Gets

    public function getIdProducto() { return $this->idProducto; }
    public function getProNombre() { return $this->proNombre; }
    public function getProDetalle() { return $this->proDetalle; }
    public function getProCantStock() { return $this->proCantStock; }
    public function getMensajeOperacion() { return $this->mensajeOperacion; }
    public function getImagen(){return $this->imagen;}
    
    // Sets

    public function setIdProducto($idProductoNuevo) { $this->idProducto = $idProductoNuevo; }
    public function setProNombre($proNombreNuevo) { $this->proNombre = $proNombreNuevo; }
    public function setProDetalle($proDetalleNuevo) { $this->proDetalle = $proDetalleNuevo; }
    public function setProCantStock($proCantStockNuevo) { $this->proCantStock = $proCantStockNuevo; }
    public function setImagen($imagen){$this->imagen = $imagen;}
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
                    $imagen = $row['imagen'];
                    $proCantStock = $row['proCantStock'];
                    $this->setear($idProducto, $proNombre, $proDetalle, $imagen, $proCantStock);
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
        "INSERT INTO producto (proNombre, proDetalle, proCantStock)  
        VALUES('" . $this->getProNombre() . "','" . $this->getProDetalle() . "','" . $this->getImagen() . "','". $this->getProCantStock()."');";
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
            imagen='" . $this->getImagen()."',
            proCantStock='" . $this->getProCantStock()."'
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
                    $imagen = $row['imagen'];
                    $proCantStock = $row['proCantStock'];
                    $obj->setear($idProducto, $proNombre, $proDetalle, $imagen, $proCantStock);
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
            ".<br>la ruta de la imagen es: " . $this->getImagen() .
            ".<br>La cant de stock es: " . $this->getProCantStock()."<br>";
        return $frase;
    }
}
?>