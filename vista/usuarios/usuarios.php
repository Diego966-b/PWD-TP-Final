<?php
include_once("../../config.php");
$pagSeleccionada = "Gestionar Usuarios";
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
    }
    ?>

</head>

<body>

    <?php
    $objUsuario = new AbmUsuario;
    $objRolUsuario = new AbmUsuarioRol;
    $objRol = new AbmRol;

    $listadoRoles = $objRol->buscar(null);
    $listaUsuarios = $objUsuario->buscar(null);
    $listadoRolesYusuarios = $objRolUsuario->buscar(null);

    ?>
    <div id="filtro-opacidad">
        <div id="contenido-perfil-n">
            <br>
            <br>
        <div class="container text-center p-4 mt-3 cajaLista">
            <h2>Lista de usuarios </h2>
            <div class="table-responsive">
                <table class="table m-auto">
                    <thead class="table-dark fw-bold">
                        <tr>
                            <td>ID </td>
                            <td>Nombre Usuario</td>
                            <td>Password</td>
                            <td>Mail</td>
                            <td>Estado</td>
                            <td>Rol</td>
                            <td>Acciones</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($listaUsuarios) > 0) {
                            foreach ($listaUsuarios as $user) {
                                echo '<tr><td>' . $user->getIdUsuario() . '</td>';
                                echo '<td>' . $user->getUsNombre() . '</td>';
                                echo '<td>' . $user->getUsPass() . '</td>';
                                echo '<td>' . $user->getUsMail() . '</td>';
                                if ($user->getUsDeshabilitado() == null) {
                                    echo '<td>Activo</td>';
                                } else {
                                    echo '<td>Baja desde: ' . $user->getUsDeshabilitado() . '  </td>';
                                }
                                echo '<td>';
                                foreach ($listadoRoles as $roles) {
                                    foreach ($listadoRolesYusuarios as $rolesUsuarios) {
                                        $objUsuario = $rolesUsuarios->getObjUsuario();
                                        $objRol = $rolesUsuarios->getObjRol();
                                        $roles->getIdRol();
                                        $user->getIdUsuario();
                                        if ($objRol->getIdRol() ==  $roles->getIdRol() && $objUsuario->getIdUsuario() == $user->getIdUsuario()) {
                                            echo " " . $roles->getRolDescripcion() . " ";
                                        }
                                    }
                                }
                                echo '</td>';
                                echo "<td>";
                                if ($user->getUsDeshabilitado() == null) {
                                    echo '<button class="btn btn-danger mx-1 " onclick="eliminarUsuario(' . $user->getIdUsuario() . ')">Dar baja</button>';
                                } else {
                                    echo '<button class="btn btn-success mx-1  " onclick="altaUsuario(' . $user->getIdUsuario() . ')">Dar de alta</button>';
                                }
                                echo '<button type="button mx-1" class="btn btn-primary btn-modificar"  id="modificar"  >Editar</button>';
                                echo "</td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
        <!-- Modal editar -->
        <div class="modal fade" id="editarModal" name="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form name="editarForm" id="editarForm" method="post">
                    <div class="modal-content">
                        <div class="modal-header bg-dark text-light">
                            <h1 class="modal-title fs-5" id="editarModalLabel">Editar</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id='idUsuario' name="idUsuario">
                            <div class="mb-3">
                                <label for="usNombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="usNombre" name="usNombre">
                            </div>
                            <div class="mb-3">
                                <label for="usMail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="usMail" name="usMail">
                            </div>

                            <div class="mb-3">
                                <label for="usPass" class="form-label">Password</label>
                                <input type="password" class="form-control" id="usPass" name="usPass">
                            </div>
                            <div class="mb-3">
                                <select class="form-select" aria-label="Default select example" name="idRol" id="idRol">
                                    <option selected>Seleciona un Rol</option>
                                    <option value="1">Admin</option>
                                    <option value="2">Cliente</option>
                                    <option value="3">Deposito</option>
                                </select>
                            </div>
                            <input id="accion" name="accion" value="editar" type="hidden">
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
    <script src="./js/funcionesAmbUsuario.js"></script>

    <?php include_once($ESTRUCTURA . "/pie.php"); ?>
</body>

</html>