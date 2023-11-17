<?php
include_once("../../config.php");
$pagSeleccionada = "Mi Perfil";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once($ESTRUCTURA . "/header.php"); ?>
    
    <?php include_once($ESTRUCTURA . "/cabeceraBD.php"); 
      if ($objSession->validar()) {
        $tienePermiso = $objSession->tienePermisoB($objSession->getUsuario());
        if (!$tienePermiso) {
            header("Refresh: 0; URL='$VISTA/acceso/login.php'");
        }
        $estadoPagina = $objSession->estadoMenu();
        if (!$estadoPagina) {
            header("Refresh: 0; URL='$VISTA/home/index.php'");
        }
    } else {
        header("Refresh: 0; URL='$VISTA/acceso/login.php'");
    } ?>

  
</head>

<body>
    <div id="filtro-opacidad">
        <div id="contenido-perfil-n">
            <br>
            <br>
            <?php          
            $objUsuario = $objSession->getUsuario();
            if ($objUsuario <> null) {
                if ($objUsuario->getUsDeshabilitado() == null) {
                    $listRolesUsuario = $objSession->getRol();
            ?>
                    <div class="cajaLista container p-4 my-5 text-center">
                        <h3>Datos de Perfil </h3>
                        <table class="table m-auto ">
                            <thead class="table-dark fw-bold">
                                <tr>
                                    <th>ID Usuario</th>
                                    <th>Nombre</th>
                                    <th>Mail</th>
                                    <th>Roles</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tr>
                                <td><?php echo $objUsuario->getIdUsuario() ?></td>
                                <td><?php echo $objUsuario->getUsNombre() ?></td>
                                <td><?php echo $objUsuario->getUsMail() ?></td>
                                <td><?php foreach ($listRolesUsuario as $objUsuRol) {
                                        echo $objUsuRol->getObjRol()->getRolDescripcion() . " ";
                                    } ?>
                                </td>
                                <td>
                                    <?php echo '<button class="btn btn-primary modificarPerfil"  id="modificarPerfil" >Editar datos</button>' ?>
                                </td>
                            </tr>
                        </table>
                    </div>

            <?php
                } else {
                    echo '<div class="container mt-5">';
                    echo '<div class="alert alert-warning" role="alert">';
                    echo 'El usuario está deshabilitado';
                    echo '</div></div>';
                }
            }
            ?>

            <!-- Modal editar -->
            <div class="modal fade" id="editarPerfilModal" name="editarPerfilModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <form name="" id="" method="post">
                        <div class="modal-content">
                            <div class="modal-header bg-dark text-light">
                                <h1 class="modal-title fs-5" id="editarModalLabel">Editar</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label for="usNombre" class="form-label">Nombre de usuario</label>
                                <input type="text" class="form-control" id="usNombre" name="usNombre" placeholder="Pepe">
                                <br>
                                <label for="usPass" class="form-label">Nueva Contrase&ntilde;a</label>
                                <input type="password" class="form-control" id="usPass" name="usPass" placeholder="****">
                                <br>
                                <label for="usMail" class="form-label">Correo Electronico:</label>
                                <input type="mail" class="form-control" id="usMail" name="usMail" placeholder="nombre@gmail.com">
                                <br>
                                <input id="accion" name="accion" value="editar" type="hidden">
                                <input id="idUsuario" name="idUsuario" type="hidden">
                            </div>
                            <div class="modal-footer  bg-dark">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-success" onclick="guardarCambios()">Guardar Cambios</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="./js/funcionesEditarPerfil.js"></script>
    <?php include_once($ESTRUCTURA . "/pie.php"); ?>
</body>

</html>