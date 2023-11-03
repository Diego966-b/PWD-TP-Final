<?php
    $colPaginas = [];
    array_push($colPaginas, "login");
?>
<script>
$(document).ready(function () {
    alert("El documento está listo."); // Agregar esta línea de prueba
    // Inicializa los dropdowns
    $('.dropdown-toggle').dropdown();
});

</script>

<div class="bg-dark sticky-top">
    <h1 class="text-white text-center m-0">TP Login</h1>
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-center flex-fill"> <!-- Utiliza text-center para centrar el contenido generado por el bucle y flex: 1 para expandirlo al máximo -->
            <?php
                for ($i = 0; $i < count($colPaginas); $i++) {
                    $seleccionado = ($pagSeleccionada == $colPaginas[$i]) ? "link-underline-light link-underline-opacity-100" : "";
                    echo '<h2 class="m-3">
                    <a class="link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover'.$seleccionado.'" href="'.$VISTA.'/'.$colPaginas[$i].'/'.$colPaginas[$i].'.php">'.$colPaginas[$i].'</a></h2>';
                }
            ?>
        </div>
        <div class="text-end ms-auto"> <!-- Utiliza text-end y ms-auto para alinear la imagen a la derecha -->
            <div class="dropdown">
                <a class="btn btn-dark dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <img src="<?php echo $VISTA;?>../img/usuario1.svg" class="rounded" height="100px">
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
