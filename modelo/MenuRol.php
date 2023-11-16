<?php
class MenuRol 
{
    // Atributos

    private $objRol, $objMenu, $mensajeOperacion;

    // Constructor y setear

    public function __construct()
    {
        $this -> objRol = new Rol();
        $this -> objMenu = new Menu();
    }

    public function setear($objRol, $objMenu)
    {
        $this -> setObjRol($objRol);
        $this -> setObjMenu($objMenu);
    }

    // Gets

    public function getObjRol() { return $this->objRol; }
    public function getObjMenu() { return $this->objMenu; }
    public function getMensajeOperacion() { return $this->mensajeOperacion; }

    // Sets

    public function setObjRol($objRol) { $this->objRol = $objRol; }
    public function setObjMenu($objMenu) { $this->objMenu = $objMenu; }
    public function setMensajeOperacion($mensajeOperacion) { $this->mensajeOperacion = $mensajeOperacion; }

    // Metodos

    public function cargar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $objMenu = $this -> getObjMenu();
        $objRol = $this -> getObjRol();
        $sql = 
        "SELECT * FROM menuRol WHERE idMenu = " . $objMenu->getIdMenu()." AND idRol = ".$objRol->getIdRol();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $abmMenu = new AbmMenu();
                    $abmRol = new AbmRol();
                    $array = [];
                    $array ['idRol'] = $row['idRol'];
                    $array ['idMenu'] = $row['idMenu'];
                    $listaMenus = $abmMenu -> buscar ($array);
                    $listaRoles = $abmRol -> buscar ($array);
                    $objMenu = $listaMenus[0];
                    $objRol = $listaRoles[0]; // Si hay mas de 1 rol aca priorizaria el primero que encuentra!!!
                    $this -> setear($objRol, $objMenu);
                }
            }
        } else {
            $this->setMensajeOperacion("menuRol->listar: " . $base->getError());
        }
        return $respuesta;
    }

    public function insertar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $objMenu = $this->getObjMenu();
        $objRol = $this->getObjRol();
        $sql = 
        "INSERT INTO menuRol (idMenu, idRol)
            VALUES ('" . $objMenu->getIdMenu() . "', '" . $objRol->getIdRol() . "')";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("menuRol->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("menuRol->modificar: " . $base->getError());
        }
        return $respuesta;
    }

    public function modificar(){
        $resp = false;
        return $resp;
    }

    public function eliminar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $objMenu = $this->getObjMenu();
        $objRol = $this->getObjRol();
        $sql = "DELETE FROM menuRol WHERE idMenu = " . $objMenu->getIdMenu()." AND idRol = ".$objRol->getIdRol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("menuRol->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("menuRol->eliminar: " . $base->getError());
        }
        return $respuesta;
    }

    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos;
        $sql = "SELECT * FROM menuRol ";
        if ($parametro != "") {
            $sql .= "WHERE " . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new MenuRol();
                    $abmMenu = new AbmMenu();
                    $abmRol = new AbmRol();
                    $array = [];
                    $array ['idRol'] = $row['idRol'];
                    $array ['idMenu'] = $row['idMenu'];
                    $listaMenus = $abmMenu -> buscar ($array);
                    $listaRoles = $abmRol -> buscar ($array);
                    $objMenu = $listaMenus[0];
                    $objRol = $listaRoles[0]; // Si hay mas de 1 rol aca priorizaria el primero que encuentra!!!
                    $obj->setear($objRol, $objMenu); 
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
        $objRol = $this->getObjRol();
        $objMenu = $this -> getObjMenu();
        $frase =
            "<br>El id del rol es: " . $objRol->getIdRol() .
            ".<br>El id del menu es: " . $objMenu->getIdMenu()."<br>";
        return $frase;
    }
}
?>