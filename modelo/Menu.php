<?php
class Menu {

    // Atributos

    private $meDeshabilitado, $mensajeOperacion, $objMenu, $meDescripcion, $meNombre, $idMenu;
    
    // Constructor y setear

    public function __construct(){
        $this->idMenu="";
        $this->meNombre="" ;
        $this->meDescripcion="";
        $this->objMenu= null;
        $this->meDeshabilitado = null;
        $this->mensajeOperacion ="";
        
    }

    public function setear($idMenu, $meNombre,$meDescripcion,$objMenu,$meDeshabilitado)    {
        $this->setIdMenu($idMenu);
        $this->setMeNombre($meNombre);
        $this->setMeDescripcion($meDescripcion);
        $this->setObjMenu($objMenu);
        $this->setMeDeshabilitado($meDeshabilitado);
    }

    // Set
    public function setIdMenu($idMenu) { $this->idMenu = $idMenu; }
    public function setMeNombre($meNombre) { $this->meNombre = $meNombre; }
    public function setMeDescripcion($meDescripcion) { $this->meDescripcion = $meDescripcion; }
    public function setObjMenu($objMenu) { $this->objMenu = $objMenu; }
    public function setMeDeshabilitado($meDeshabilitado) { $this->meDeshabilitado = $meDeshabilitado; }
    public function setMensajeoperacion($mensajeOperacion) { $this->mensajeOperacion = $mensajeOperacion; }
    
    // Get

    public function getIdMenu() { return $this->idMenu; }
    public function getMeNombre() { return $this->meNombre; }
    public function getMeDescripcion() { return $this->meDescripcion; }
    public function getObjMenu() { return $this->objMenu; }
    public function getMeDeshabilitado() { return $this->meDeshabilitado; }
    public function getMensajeoperacion() { return $this->mensajeOperacion; }
    
    // Metodos

    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM menu WHERE idMenu = ".$this->getIdMenu();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $objMenuPadre =null;
                    if ($row['idPadre']!=null or $row['idPadre']!='' ){
                        $objMenuPadre = new Menu();
                        $objMenuPadre->setIdMenu($row['idPadre']);
                        $objMenuPadre->cargar();
                    }
                    $this->setear($row['idMenu'], $row['meNombre'],$row['meDescripcion'],$objMenuPadre,$row['meDeshabilitado']); 
                }
            }
        } else {
            $this->setMensajeoperacion("menu->cargar: ".$base->getError()[2]);
        }
        return $resp;
    }
    
    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="INSERT INTO menu( meNombre ,  meDescripcion ,  idPadre ,  meDeshabilitado)  ";
        $sql.="VALUES('".$this->getMeNombre()."','".$this->getMeDescripcion()."',";
        if ($this->getObjMenu()!= null)
            $sql.=$this->getObjMenu()->getIdMenu().",";
        else
            $sql.="null,";
        if ($this->getMeDeshabilitado()!=null)
            $sql.= "'".$this->getMeDeshabilitado()."'";
        else 
            $sql.="null";
        $sql.= ");";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdMenu($elid);
                $resp = true;
            } else {
                $this->setMensajeoperacion("menu->insertar: ".$base->getError()[2]);
            }
        } else {
            $this->setMensajeoperacion("menu->insertar: ".$base->getError()[2]);
        }
        return $resp;
    }
    
    public function modificar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="UPDATE menu SET meNombre='".$this->getMeNombre()."',meDescripcion='".$this->getMeDescripcion()."'";
        if ($this->getObjMenu()!= null)
            $sql.=",idPadre= ".$this->getObjMenu()->getIdMenu();
         else
            $sql.=",idPadre= null";
         if ($this->getMeDeshabilitado()!=null)
             $sql.= ",meDeshabilitado='".$this->getMeDeshabilitado()."'";
         else
              $sql.=" ,meDeshabilitado=null";
        $sql.= " WHERE idMenu = ".$this->getIdMenu();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
                
            } else {
                $this->setMensajeoperacion("menu->modificar 1: ".$base->getError());
            }
        } else {
            $this->setMensajeoperacion("menu->modificar 2: ".$base->getError());
        }
        return $resp;
    }
    
    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="DELETE FROM menu WHERE idMenu =".$this->getIdMenu();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeoperacion("menu->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeoperacion("menu->eliminar: ".$base->getError());
        }
        return $resp;
    }
    public function eliminarLogico(){
        $resp = false;
        $base = new BaseDatos();
        $sql = 
        "UPDATE menu SET meDeshabilitado = NOW() WHERE idMenu='" . $this->getIdMenu() . "'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("menu->eliminarLogico: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("menu->eliminarLogico: " . $base->getError());
        }
        return $resp;
    }
    public function activarMenu (){
        $resp = false;
        $base = new BaseDatos();
        $sql = 
        "UPDATE menu SET meDeshabilitado = null WHERE idMenu='" . $this->getIdMenu() . "'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("menu->eliminarLogico: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("menu->eliminarLogico: " . $base->getError());
        }
        return $resp;
    }

    
    public static  function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM menu ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $obj = new Menu();
                    $objMenuPadre =null;
                    if ($row['idPadre']!=null){
                        $objMenuPadre = new Menu();
                        $objMenuPadre->setIdMenu($row['idPadre']);
                        $objMenuPadre->cargar();
                    }
                    $obj->setear($row['idMenu'], $row['meNombre'],$row['meDescripcion'],$objMenuPadre,$row['meDeshabilitado']); 
                    array_push($arreglo, $obj);
                } 
            }
        } 
        return $arreglo;
    }

    public function __toString()
    {
        $frase = "Datos del objMenu: Estado".$this -> getMeDeshabilitado()."<br>objto" .$this -> getObjMenu()."<br>descripcion" . $this -> getMeDescripcion()."<br>nombre" .$this -> getMeNombre()."ID". $this -> getIdMenu();
        return $frase;
    }
}
?>