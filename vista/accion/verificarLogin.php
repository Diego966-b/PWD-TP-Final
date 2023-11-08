<?php
    include_once("../../config.php");
    $pagSeleccionada = "login";
    $rol = "noSeguro";
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
    <?php include_once($ESTRUCTURA."/cabecera.php");
        $objEncriptar = new Encriptar();
        $objUsuarioAuth = new UsuarioAuth();
        $usPassEncriptada = $objEncriptar -> encriptarMd5($contraseniaIngresada);
        $valido = $objUsuarioAuth -> validarCredenciales($nombreIngresado, $usPassEncriptada);
        if ($valido)
        {
            $objSesion = new Sesion();
            $objSesion -> iniciar($nombreIngresado, $usPassEncriptada);
            echo '
            <div class="bg-success-subtle">
                <h3 class="text-success fs-5 text-center p-3">Sesion iniciada, redirigiendo</h3>
            </div>';
            header("Refresh: 2; URL='$VISTA/usuarios/usuarios.php'");
        }
        else
        {
            echo '
            <div class="bg-danger">
                <h3 class="fs-5 text-center p-3">Error, usuario o contrase&ntilde;a incorrectos, redirigiendo</h3>
            </div>';
            header("Refresh: 2; URL='$VISTA/login.php'");
        }
    ?>
    <?php include_once($ESTRUCTURA."/pie.php");?>
</body>
</html>