<?php

    $rolCliente = [];
    array_push($rolCliente, "vistaPublica");
    array_push($rolCliente, "articulos");
    array_push($rolCliente, "tuCuenta");
    array_push($rolCliente, "carrito");
    $rolNoSeguro = [];
    array_push($rolNoSeguro, "vistaPublica");
    array_push($rolNoSeguro, "registrarse");
    array_push($rolNoSeguro, "login");
    $rolDeposito = [];
    array_push($rolDeposito, "vistaPublica");
    array_push($rolDeposito, "articulosNuevo");
    array_push($rolDeposito, "gestionarArticulos");
    array_push($rolDeposito, "tuCuenta");
    $rolAdmin = [];
    array_push($rolAdmin, "vistaPublica");
    array_push($rolAdmin, "nuevoUsuario");
    array_push($rolAdmin, "gestionarUsuarios");
    array_push($rolAdmin, "nuevoRol");
    array_push($rolAdmin, "gestionarRoles");
    array_push($rolAdmin, "nuevoMenu");
    array_push($rolAdmin, "gestionarMenus");
    array_push($rolAdmin, "tuCuenta");
?>
<div class="bg-dark sticky-top">
    <div class="d-flex justify-content-center">
<?php
    if ($rol == "cliente")
    {
        echo '<h2 class="m-3 link-light">Rol cliente:</h2>';
        for ($i = 0; $i < count($rolCliente); $i++) {
            $seleccionado = ($pagSeleccionada == $rolCliente[$i]) ? "link-underline-light link-underline-opacity-100" : "";
            echo 
            '<h2 class="m-3"><a class="link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover '.$seleccionado.'" href="'.$VISTA.'/'.$rolCliente[$i].'.php">'.$rolCliente[$i].'</a></h2>';
        }
    }
    if ($rol == "noSeguro")
    {
        echo '<h2 class="m-3 link-light">Rol NoSeguro:</h2>';
        for ($i = 0; $i < count($rolNoSeguro); $i++) {
            $seleccionado = ($pagSeleccionada == $rolNoSeguro[$i]) ? "link-underline-light link-underline-opacity-100" : "";
            echo 
            '<h2 class="m-3"><a class="link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover '.$seleccionado.'" href="'.$VISTA.'/'.$rolNoSeguro[$i].'.php">'.$rolNoSeguro[$i].'</a></h2>';
        }
    }
    if ($rol == "deposito")
    {
        echo '<h2 class="m-3 link-light">Rol Deposito:</h2>';
        for ($i = 0; $i < count($rolDeposito); $i++) {
            $seleccionado = ($pagSeleccionada == $rolDeposito[$i]) ? "link-underline-light link-underline-opacity-100" : "";
            echo 
            '<h2 class="m-3"><a class="link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover '.$seleccionado.'" href="'.$VISTA.'/'.$rolDeposito[$i].'.php">'.$rolDeposito[$i].'</a></h2>';
        }
        
    }
    if ($rol == "admin")
    {
        echo '<h2 class="m-3 link-light">Rol Admin:</h2>';
        for ($i = 0; $i < count($rolAdmin); $i++) {
            $seleccionado = ($pagSeleccionada == $rolAdmin[$i]) ? "link-underline-light link-underline-opacity-100" : "";
            echo 
            '<h2 class="m-3"><a class="link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover '.$seleccionado.'" href="'.$VISTA.'/'.$rolAdmin[$i].'.php">'.$rolAdmin[$i].'</a></h2>';
        }
    }
    echo "<h2 class='m-3'><a class='link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover' href=".$VISTA."/home/index.php>Home</a></h2>";
    echo "</div>";
?>    
</div>