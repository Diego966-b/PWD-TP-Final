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

    /**
     * Realiza el registro de un usuario. Retorna un arreglo con un mensaje y un booleano.
     */
    public function registrarUsuario ($usPassEncriptada, $usNombreIngresado, $emailIngresado)
    {
        $nombreValido = $this -> validarNombre($usNombreIngresado);
        $resultadoOperacion = [];
        $resultadoOperacion ["exito"] = false;
        if ($nombreValido)
        {
            $datosRegistro = [];
            $datosRegistro ["usPass"] =  $usPassEncriptada;
            $datosRegistro ["usNombre"] = $usNombreIngresado;
            $datosRegistro ["usMail"] = $emailIngresado;
            $datosRegistro ["accion"] = "nuevo";
            $abmUsuario = new AbmUsuario();
            $resultado = $abmUsuario -> abm ($datosRegistro);
            if ($resultado ["exito"])
            {
                $listaUsuarios = $abmUsuario -> buscar($datosRegistro);
                $usuario = $listaUsuarios[0];
                $idUsuario = $usuario -> getIdUsuario();
                $idRolCliente = $this -> buscarRol("cliente");
                if ($idRolCliente <> "")
                {
                    $datosRol ["idRol"] = $idRolCliente;
                    $datosRol ["idUsuario"] = $idUsuario;
                    $datosRol ["accion"] = "nuevoRol";
                    $resultado = $abmUsuario -> abm ($datosRol);
                    if ($resultado ["exito"])
                    {
                        $resultadoOperacion ["exito"] = true;
                        $resultadoOperacion ["mensaje"] = "El registro se realizo con exito";
                    }
                    else
                    {
                        // No se pudo cargar el rol, se cargo un usuario sin rol.
                        $resultadoOperacion ["exito"] = false;
                        $resultadoOperacion ["mensaje"] = "Error al cargar el rol, se cargo un usuario sin rol";
                    }
                }
                else
                {
                    // No esta cargado el rol cliente
                    $resultadoOperacion ["exito"] = false;
                    $resultadoOperacion ["mensaje"] = "Error no existe el rol cliente, se cargo un usuario sin rol";
                }
            } 
            else
            {
                // No se pudo cargar el usuario
                $resultadoOperacion ["exito"] = false;
                $resultadoOperacion ["mensaje"] = "Error al cargar el usuario";
            } 
        }
        else
        {
            // Nombre duplicado
            $resultadoOperacion ["exito"] = false;
            $resultadoOperacion ["mensaje"] = "Error el nombre no puede estar duplicado";
        }
        return $resultadoOperacion;
    }
    
    /**
     * Retorna el ID del rol que coincide con la descripcion recibida.
     */
    public function buscarRol ($rolDescripcionIngresado)
    {
        $abmRol = new AbmRol();
        $listaRoles = $abmRol -> buscar(null);
        $idRolBuscado = "";
        foreach ($listaRoles as $rol)
        {
            $rolDescripcion = $rol -> getRolDescripcion();
            if ($rolDescripcion == $rolDescripcionIngresado)
            {
                $idRolBuscado = $rol -> getIdRol();
            }
        }
        return $idRolBuscado;
    }

    /**
     * Verifica si el nombre de usuario ingresado no coincide con alguno de la BD.
     */
    public function validarNombre ($usNombreIngresado)
    {   
        $abmUsuario = new AbmUsuario();
        $listaUsuarios = $abmUsuario -> buscar(null);
        $valido = true;
        if (count($listaUsuarios) > 0)
        {
            foreach ($listaUsuarios as $usuario)
            {
                $usNombre = $usuario -> getUsNombre();
                if ($usNombre == $usNombreIngresado) 
                {
                    $valido = false;
                }
            }
        }
        return $valido;
    }

    /**
     * Verifica si el usuario y contraseña ingresados coinciden con alguno en la BD.
     */
    public function validarCredenciales ($usNombreIngresado, $usPassEncriptadaIngresada)
    {
        $abmUsuario = new AbmUsuario();
        $listaUsuarios = $abmUsuario -> buscar(null);
        $valido = false;
        if (count($listaUsuarios) > 0)
        {
            foreach ($listaUsuarios as $usuario)
            {
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