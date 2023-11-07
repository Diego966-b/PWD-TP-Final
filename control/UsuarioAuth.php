<?php
class UsuarioAuth
{
    // Atributos

    private $usPass, $usNombre;

    // Constructor

    public function __construct()
    {
        $this -> usPass = "";
        $this -> usNombre = "";
    }

    public function validarCredenciales ($usNombreIngresado, $usPassEncriptadaIngresada)
    {
        $abmUsuario = new AbmUsuario();
        $listaUsuarios = $abmUsuario -> buscar(null);
        $valido = false;
        if (count($listaUsuarios) > 0)
        {
            foreach ($listaUsuarios as $usuario)
            {
                echo $usuario;
                $usPass = $usuario -> getUsPass();
                $usNombre = $usuario -> getUsNombre();
                $usDeshabilitado = $usuario -> getUsDeshabilitado();
                if (($usPass == $usPassEncriptadaIngresada) && ($usNombre == $usNombreIngresado) && ($usDeshabilitado == null))
                {
                    $valido = true;
                }
            }
        }
        return $valido;
    }

    // Gets

    public function getUsPass() { return $this -> usPass; }
    public function getUsNombre() { return $this -> usNombre;}

    // Sets

    public function setUsPass ($usPassNuevo) { $this -> usPass = $usPassNuevo;}
    public function setUsNombre ($usNombreNuevo) { $this -> usNombre = $usNombreNuevo;}
}

?>