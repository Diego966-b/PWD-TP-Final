<?php
    include_once("../../config.php");
    $pagSeleccionada = "Mi Perfil";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once($ESTRUCTURA."/header.php"); ?>
    <?php include_once($ESTRUCTURA."/cabeceraBD.php"); ?>
</head>
<body>
    <?php 
        if ($objSession -> validar())
        {
            $tienePermiso = $objSession -> tienePermisoB($objSession->getUsuario());
            if (!$tienePermiso)
            {
                header("Refresh: 3; URL='$VISTA/acceso/login.php'");
            }
        }
        else
        {
            header("Refresh: 3; URL='$VISTA/acceso/login.php'");
        }
        $objUsuario = $objSession -> getUsuario();
        if ($objUsuario <> null)
        {
            if ($objUsuario->getUsDeshabilitado() == null) {
                $objUsuarioRol = $objSession -> getRol();
                $objRol = $objUsuarioRol -> getObjRol();
                echo '<div class="container mt-5">';
                echo '<div class="row justify-content-center">';
                echo '<div class="col-md-6">';
                echo '<h1>Datos de tu perfil</h1>';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">Nombre: ' . $objUsuario->getUsNombre() . '</h5>';
                echo '<p class="card-text">Contrase&ntilde;a: ' . $objUsuario->getUsPass() . '</p>';
                echo '<p class="card-text">Correo Electrónico: ' . $objUsuario->getUsMail() . '</p>';
                echo '<p class="card-text">Rol actual: ' . $objRol->getRolDescripcion() . '</p>';
                echo "<a href='#'>Editar tus datos</a>";
                echo '</div></div>';
                echo '</div></div></div>';
            } else {
                echo '<div class="container mt-5">';
                echo '<div class="alert alert-warning" role="alert">';
                echo 'El usuario está deshabilitado';
                echo '</div></div>';
            }
        }
        ?>
    <?php include_once($ESTRUCTURA."/pie.php"); ?>
</body>
</html>