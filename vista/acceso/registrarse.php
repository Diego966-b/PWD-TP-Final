<?php
    include_once("../../config.php");
    $pagSeleccionada = "Registrarse";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include($ESTRUCTURA . "/header.php"); ?>
</head>
<body>
    <?php include($ESTRUCTURA . "/cabeceraBD.php"); ?>
    <div id="filtro-opacidad">
        <div id="contenido">
            <div class="container text-center p-4 mt-3 cajaLista col-4">
                <h3>Registro</h3>
                <div>
                    <form name="registrarForm" id="registrarForm" method="post" action="<?php echo $VISTA; ?>/accion/verificarRegistro.php" class="mb-3">
                        <label for="usNombre" class="form-label">Nombre de usuario</label>
                        <input type="text" class="form-control" id="usNombre" name="usNombre" placeholder="Pepe">
                        <br>
                        <label for="usPass" class="form-label">Contrase&ntilde;a</label>
                        <input type="password" class="form-control" id="usPass" name="usPass" placeholder="****">
                        <br>
                        <label for="usMail" class="form-label">Correo Electronico:</label>
                        <input type="mail" class="form-control" id="usMail" name="usMail" placeholder="nombre@gmail.com">
                        <br>
                        <input type="submit" value="Enviar" class="btn btn-success mt-4">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include($ESTRUCTURA . "/pie.php"); ?>
    <script src="<?php echo $JS; ?>/validar.js"></script>
</body>

</html>