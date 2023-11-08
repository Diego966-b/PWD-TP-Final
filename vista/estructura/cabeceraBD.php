<?php
    include_once("../../config.php");
    $objSession = new Sesion();
    $menues = [];
    if ($objSession->activa()) {
        $objUsuarioRol = $objSession->getRol();
        // $rolActual = $arregloRoles [0];
        $objRol = $objUsuarioRol -> getObjRol();
        $idRol = $objRol -> getIdRol();
        //echo "Obj: ".$objUsuarioRol;


        $objMenuRol = new AbmMenuRol();
        $objRol = new AbmRol();
        $menues = $objMenuRol->darMenusPorRol($idRol);
        // $objRoles = $objRol->obtenerObj($idRoles);
    }
?>
<div class="bg-dark sticky-top">
    <div class="d-flex justify-content-center">
<?php
    foreach ($menues as $objMenu) {
        // print_r($menues);
        if ($objMenu->getMeDeshabilitado() == NULL) {
            $nombreMenu = $objMenu -> getMeNombre();
            echo "pagSelcinad = ".$pagSeleccionada."<br>";
            echo "nombreMenu = ".$nombreMenu."<br>";
            $seleccionado = ($pagSeleccionada == $nombreMenu) ? "link-underline-light link-underline-opacity-100" : "";
        //echo '<h2 class="m-3"><a class="link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover>'.$objMenu->getMeDescripcion().'</a></h2><br>';
            // echo $seleccionado."<br>";
        //echo '<h2 class="m-3"><a class="link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover>'.$objMenu->getMeNombre().'</a></h2><br>';
echo 
'<h2 class="m-3"><a class="link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover '.$seleccionado.'" href="'.$objMenu->getMeDescripcion().'">'.$objMenu->getMeNombre().'</a></h2>';
}
    }
      ?>
    </div>
</div>