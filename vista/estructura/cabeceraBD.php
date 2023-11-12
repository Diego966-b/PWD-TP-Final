<?php
    include_once("../../config.php");
    $objSession = new Session();
    $sesionValida = $objSession->validar();
    $menues = [];
    if ($sesionValida) {
        $objUsuarioRol = $objSession->getRol();
        $objRol = $objUsuarioRol -> getObjRol();
        $idRol = $objRol -> getIdRol();
        // echo "IDROL: ".$idRol."<br>";
        $objMenuRol = new AbmMenuRol();
        $objRol = new AbmRol();
        $menues = $objMenuRol->darMenusPorRol($idRol);
        // $objRoles = $objRol->obtenerObj($idRoles);
    }
    else
    {
        //$objSession -> cerrar();
        header("Refresh: 2; URL='$VISTA/acceso/login.php'");
        //echo session_status();
    }
?>
<div class="bg-dark sticky-top">
    <div class="d-flex justify-content-center">
<?php
    foreach ($menues as $objMenu) {
        if ($objMenu->getMeDeshabilitado() == NULL) {
            $nombreMenu = $objMenu -> getMeNombre();
            $seleccionado = ($pagSeleccionada == $nombreMenu) ? "link-underline-light link-underline-opacity-100" : "";
            echo 
            '<h2 class="m-3">
            <a class="link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover '.$seleccionado.'" href="'.$objMenu->getMeDescripcion().'">'
            .$objMenu->getMeNombre().
            '</a>
            </h2>';
        }
    }
    if ($sesionValida) {
        echo 
        '<form name="cerrarSesion" id="cerrarSesion" method="post" action='.$VISTA.'/accion/eliminarSesion.php>
        <input class="m-3 p-2"type="submit" value="Cerrar Sesion">
        </form>';
    }
    else
    {
        $nombrePagina = [];
        array_push($nombrePagina, "Iniciar Sesion");
        array_push($nombrePagina, "Registrarse");
        //array_push($nombrePagina, "Vista Segura");
        $ubicacionPagina = [];
        array_push($ubicacionPagina, "/acceso/login");
        array_push($ubicacionPagina, "/acceso/registrarse");
        //array_push($ubicacionPagina, "UBICACIONVISTASEGURA");
        for ($i = 0; $i < count($nombrePagina); $i++)
        {
            $seleccionado = ($pagSeleccionada == $nombrePagina[$i]) ? "link-underline-light link-underline-opacity-100" : "";
            echo 
            '<h2 class="m-3">
            <a class="link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover '.$seleccionado.'" href="'.$VISTA.$ubicacionPagina[$i].'.php">
            '.$nombrePagina[$i].'
            </a>
            </h2>';
        }
    }
    $seleccionado = ($pagSeleccionada == "Home") ? "link-underline-light link-underline-opacity-100" : "";
    echo 
    '<h2 class="m-3">
    <a class="link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover '.$seleccionado.'" href="'.$VISTA.'/home/index.php">
    Home
    </a>
    </h2>';
?>
    </div>
</div>