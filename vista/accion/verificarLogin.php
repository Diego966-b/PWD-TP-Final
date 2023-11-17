<?php
    include_once("../../config.php");
    $pagSeleccionada = "Iniciar Sesion";
    $colDatos = devolverDatos();
    $contraseniaIngresada = $colDatos ["usPass"];
    $nombreIngresado = $colDatos ["usNombre"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once($ESTRUCTURA."/header.php");?>
</head>
<body>
    <?php include_once($ESTRUCTURA."/cabeceraBD.php");
        $objEncriptar = new Encriptar();
        $objUsuarioAuth = new UsuarioAuth();
        $usPassEncriptada = $objEncriptar -> encriptarMd5($contraseniaIngresada);
        $valido = $objUsuarioAuth -> validarCredenciales($nombreIngresado, $usPassEncriptada);
        if ($valido)
        {
            $objSession -> iniciar($nombreIngresado, $usPassEncriptada);
            echo '
            <div class="bg-success-subtle">
                <h3 class="text-success fs-5 text-center p-3">Sesion iniciada, redirigiendo</h3>
            </div>';
            header("Refresh: 1; URL='$VISTA/home/index.php'");
        }
        else
        {
            echo '
            <div class="bg-danger">
                <h3 class="fs-5 text-center p-3">Error, usuario o contrase&ntilde;a incorrectos, redirigiendo</h3>
            </div>';
            header("Refresh: 1; URL='$VISTA/acceso/login.php'");
        }
    ?>
    <?php include_once($ESTRUCTURA."/pie.php");?>
</body>
</html>