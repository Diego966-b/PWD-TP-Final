<?php
    include_once("../../config.php");
    $objSession = new Session();
    $sesionValida = $objSession->validar();
    $menues = [];
    if ($sesionValida) {
        /*
        $objUsuarioRol = $objSession->getRol();
        $objRol = $objUsuarioRol -> getObjRol();
        $idRol = $objRol -> getIdRol();
        echo "IDROL: ".$idRol."<br>";
        $objRol = new AbmRol();
        */
        $objMenuRol = new AbmMenuRol();
        $menues = $objMenuRol->darMenusPorUsuario($objSession->getUsuario());
        // $objRoles = $objRol->obtenerObj($idRoles);
    }
    else
    {
        $abmMenu = new AbmMenu();
        $array = [];
        $array ["idMenu"] = 10;
        $menu = $abmMenu -> buscar($array);
        $menues = [];
        array_push($menues, $menu[0]);
        $array ["idMenu"] = 11;
        $menu = $abmMenu -> buscar($array);
        array_push($menues, $menu[0]);
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
?>
    </div>
</div>