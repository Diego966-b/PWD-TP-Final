<?php

include_once 'conector/BaseDatos.php';

class MenuRol
{
    private $menu;
    private $rol;
    private $mensajeOperacion;

    /**************************************/
    /**************** SET *****************/
    /**************************************/
    
    public function setRol($rol)
    {
        $this->rol = $rol;
    }

    public function setMenu($menu)
    {
        $this->menu = $menu;
    }

    public function setMensajeOperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    /**************************************/
    /**************** GET *****************/
    /**************************************/

    public function getRol()
    {
        return $this->rol;
    }

    public function getMenu()
    {
        return $this->menu;
    }

    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    /**************************************/
    /************** FUNCIONES *************/
    /**************************************/

    public function __construct()
    {
        $this->menu = new Menu();
        $this->rol = new Rol();
        $this->mensajeOperacion = "";
    }

    public function setear($menu, $rol)
    {
        $this->setMenu($menu);
        $this->setRol($rol);
    }

    //carga info de bd (idUsuario+IdRol+rolDescripcion) a objeto php
    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();

        $sql = "SELECT * FROM usuariorol WHERE 
                idRol = " . $this->getRol()->getIdRol() . "
                and idMenu =" . $this->getMenu()->getIdMenu();

        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);

            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();

                    $menu = null;
                    if ($row['idMenu'] != null) {
                        $menu = new Menu();
                        $menu->setIdMenu($row['idMenu']);
                        $menu->cargar();
                    }

                    $rol = null;
                    if ($row['idRol'] != null) {
                        $rol = new Rol();
                        $rol->setIdRol($row['idRol']);
                        $rol->cargar();
                    }
                    $this->setear($menu, $rol);

                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("menurol->listar: " . $base->getError());
        }
        return $resp;
    }


    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO menurol (idMenu,idRol)  VALUES ("
            . $this->getMenu()->getIdMenu() . ","
            . $this->getRol()->getIdRol() . "
                )";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("menurol->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("menurol->insertar: " . $base->getError());
        }
        return $resp;
    }


    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM menurol WHERE 
                idMenu = " . $this->getMenu()->getIdMenu()
            . "and idRol =" . $this->getRol()->getIdRol();

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("menurol->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("menurol->eliminar: " . $base->getError());
        }
        return $resp;
    }


    public function listar($parametro = "")
    {
        $arreglo = null;
        $base = new BaseDatos();
        $sql = "SELECT * FROM menurol ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {

                $arreglo = array();
                while ($row = $base->Registro()) {

                    $menu = null;
                    if ($row['idMenu'] != null) {
                        $menu = new Menu();
                        $menu->setIdMenu($row['idMenu']);
                        $menu->cargar();
                    }

                    $rol = null;
                    if ($row['idRol'] != null) {
                        $rol = new Rol();
                        $rol->setIdRol($row['idRol']);
                        $rol->cargar();
                    }

                    $obj = new MenuRol();
                    $obj->setear($menu, $rol);
                    array_push($arreglo, $obj);
                }
            }
        }
        return $arreglo;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE menurol SET idRol =". $this->getRol()->getIdRol() .
               " WHERE menurol.idMenu =". $this->getMenu()->getIdMenu();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("menurol->insertar: " . $base->getError());
                $resp=false;
            }
        } else {
            $this->setMensajeOperacion("menurol->insertar: " . $base->getError());
        }
        return $resp;
    }

}
