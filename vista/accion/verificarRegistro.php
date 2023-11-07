<?php
    include_once("../../config.php");
    $pagSeleccionada = "registrarse";
    $rol = "noSeguro";
    $colDatos = devolverDatos();
    $usPassIngresada = $colDatos ["usPass"];
    $usNombreIngresado = $colDatos ["usNombre"];
    $emailIngresado = $colDatos ["usMail"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once($ESTRUCTURA."/header.php");?>
    <?php include_once($ESTRUCTURA."/cabecera.php"); ?>
</head>
<body>
    <?php
        $objEncriptar = new Encriptar();
        $objUsuarioAuth = new UsuarioAuth();
        $usPassEncriptada = $objEncriptar -> encriptarMd5($usPassIngresada);
        $resultado = $objUsuarioAuth -> registrarUsuario($usPassEncriptada, $usNombreIngresado, $emailIngresado);
        if ($resultado["exito"])
        {
            echo '
            <div class="bg-success-subtle">
                <h3 class="text-success fs-5 text-center p-3">'.$resultado["mensaje"].'</h3>
            </div>';
        }
        else
        {
            echo '
            <div class="bg-danger">
                <h3 class="fs-5 text-center p-3">'.$resultado["mensaje"].'</h3>
            </div>';
        }
        include_once($ESTRUCTURA."/pie.php"); 
    ?>
</body>
</html>
