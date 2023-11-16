<?php
include_once("../../config.php");
$objSession = new Session();
$sesionValida = $objSession->validar();
$menues = [];
if ($sesionValida) {
    $objAmbUsuario = new AbmUsuario();
    $objUsuario = $objSession->getUsuario();
    $param["idUsuario"] = $objUsuario->getIdUsuario();
    // arreglo de objetos usarioRol, cada objeto tiene un objeto usuario y uno ROl
    $rolesUsuario = $objAmbUsuario->darRoles($param);
    $objMenuRol = new AbmMenuRol();
    if (count($rolesUsuario) > 1) {
        // poder elegir el rol que quiere mostrar el menu
        // creo todos los menus segun el rol y los guardo en un array
        $arrayMenu = [];
        foreach ($rolesUsuario as $rolUsua) {
            $idRol = $rolUsua->getObjRol()->getIdRol();
            $menuRol = $objMenuRol->darMenusPorRol($idRol);
            // guardo el arreglo asosiativo con la clave $idRol
            $arrayMenu[$idRol] = $menuRol;
        }
        $datos = data_submitted();
        if (isset($datos['rol'])) {
            $idSeleccionado = $datos['rol'];
            $menues = $arrayMenu[$idSeleccionado];
        } else {
            $idSeleccionado = $rolesUsuario[0]->getObjRol()->getIdRol();
            $menues = $arrayMenu[$idSeleccionado];
        }
    } else {
        $idSeleccionado=null;
        $menues = $objMenuRol->darMenusPorUsuario($objUsuario);
    }
} else {
    $idSeleccionado=null;
    $abmMenu = new AbmMenu();
    $array = [];
    $array["idMenu"] = 1;
    $menu = $abmMenu->buscar($array);
    $menues = [];
    array_push($menues, $menu[0]);
    $array["idMenu"] = 11;
    $menu = $abmMenu->buscar($array);
    array_push($menues, $menu[0]);
    $array["idMenu"] = 12;
    $menu = $abmMenu->buscar($array);
    array_push($menues, $menu[0]);
}
echo '<div class="bg-dark sticky-top">';
echo '<div class="d-flex justify-content-center">';

foreach ($menues as $objMenu) {
    if ($objMenu->getMeDeshabilitado() == NULL) {
        $nombreMenu = $objMenu->getMeNombre();
        $seleccionado = ($pagSeleccionada == $nombreMenu) ? "link-underline-light link-underline-opacity-100" : "";
        echo
        '<h2 class="m-3">
            <a class="link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover ' . $seleccionado . '" href="' . $objMenu->getMeDescripcion() . '?rol='.$idSeleccionado.'">'
            . $objMenu->getMeNombre() .
            '</a>
            </h2>';
    }
}
if ($sesionValida) {
    echo
    '<form name="cerrarSesion" id="cerrarSesion" method="post" action=' . $VISTA . '/accion/eliminarSesion.php>
        <input class="m-3 p-2 btn btn-danger" type="submit" value="Cerrar Sesion">
        </form>';
}
if ($sesionValida) {
    if (count($rolesUsuario) > 1) {
        // poder elegir el rol que quiere mostrar el menu actualiza la pagina
        echo "<form id='seleccionRolesForm'accion='' method='GET'>";
        echo "<select class='m-3 p-2' name='rol'id='rol' onchange='submitForm()'> ";
        // echo "<option> Seleccione la vista del rol</option>";
        foreach ($rolesUsuario as $rolUs) {
            $rol = $rolUs->getObjRol();
            if ($idSeleccionado == $rol->getIdRol()) {
                echo "<option selected value='" . $rol->getIdRol() . "'>" . $rol->getIdRol().": " . $rol->getRolDescripcion() . "</option>";
            } else {
                echo "<option  value='" . $rol->getIdRol() . "'>". $rol->getIdRol() . ": " . $rol->getRolDescripcion() . "</option>";
            }
        }
        echo "</select>";   
        echo "</form>";
    }
}
echo '</div>';
echo '</div>';
?>
<script>
    function submitForm() {
        document.getElementById("seleccionRolesForm").submit();
    }
</script>