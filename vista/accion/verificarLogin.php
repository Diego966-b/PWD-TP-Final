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
            echo "<h1>Valido</h1>";
            header("Refresh: 2; URL='$VISTA/'");
        }
        else
        {
            echo "<h1>NoValido</h1>";
            header("Refresh: 2; URL='$VISTA/login.php'");
        }
    ?>
    <?php include_once($ESTRUCTURA."/pie.php");?>
</body>
</html>