<?php
    $objTrans = new Sesion();
    $resp= $objTrans->validar();
    if($resp){
        echo "Esta logeado";
    }else{
        echo "<h1>tiene que estar loguead</h1>";
        header("Refresh: 2; URL='$VISTA/login/login.php'");
        // echo "<script>location.href ='./login/login.php'; </script>";
    }
    $colPaginas = [];
    // $pagSeleccionada="";
    array_push($colPaginas, "");
    array_push($colPaginas, "usuarios");
    array_push($colPaginas, "roles");
    array_push($colPaginas, "pagSegura");
    array_push($colPaginas, "login");
?>
<div class="bg-dark sticky-top">
    <h1 class="text-white text-center m-0">TP Login</h1>
    <div class="d-flex justify-content-center">
<?php

    for ($i = 0; $i <    count($colPaginas); $i++) {
        $seleccionado = ($pagSeleccionada == $colPaginas[$i]) ? "link-underline-light link-underline-opacity-100" : "";
        echo 
        '<h2 class="m-3">
        <a class="link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover '.$seleccionado.'" href="'.$VISTA.'/'.$colPaginas[$i].'/'.$colPaginas[$i].'.php">'
        .$colPaginas[$i].
        '</a></h2>';
    }
?>
    </div>   
</div>
