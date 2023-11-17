<?php
include_once("../../config.php");
$pagSeleccionada = "Gestionar Roles";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once($ESTRUCTURA . "/header.php"); ?>
    <?php 
        include_once($ESTRUCTURA . "/cabeceraBD.php");
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
    $objRol = new AbmRol;
    $listadoRoles = $objRol->buscar(null);

    ?>
    <div id="filtro-opacidad">
        <div id="contenido-perfil-n">
            <br>
            <br>
    <div class="container text-center p-4 mt-3 cajaLista">
        <h2>Lista de Roles </h2>
        <div class="table-responsive">

            <table class="table m-auto">
                <thead class="table-dark fw-bold">
                    <tr>
                        <td>ID Rol </td>
                        <td>Descripcion</td>
                        <td>Estado</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($listadoRoles) > 0) {
                        foreach ($listadoRoles as $rol) {
                            echo '<tr><td>' . $rol->getIdRol() . '</td>';
                            echo '<td>' . $rol->getRolDescripcion() . '  </td>';
                            if ($rol->getRolDeshabilitado() == null) {
                                echo '<td>Activo</td>';
                            } else {
                                echo '<td>Baja desde: ' . $rol->getRolDeshabilitado() . '  </td>';
                            }
                            echo '</td>';
                            echo "<td>";
                            if ($rol->getRolDeshabilitado() == null) {
                                echo '<button class="btn btn-danger mx-1 " onclick="eliminarRol(' . $rol->getIdRol() . ')">Dar baja</button>';
                            } else {
                                echo '<button class="btn btn-success mx-1  " onclick="altaRol(' . $rol->getIdRol() . ')">Dar de alta</button>';
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
    <div class="text-center m-3">
        <button type="button" class="btn btn-success btn-nuevo" data-bs-toggle="modal" data-bs-target="#nuevoModal"> Nuevo Rol</button>
    </div>
    <!-- Modal Nuevo -->
    <div class="modal fade" id="nuevoModal" name="nuevoModal" tabindex="-1" aria-labelledby="nuevoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form name="nuevoform" id="nuevoform" method="post">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-light">
                        <h1 class="modal-title fs-5" id="editarModalLabel">Nuevo Rol</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="rolDescripcion" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="rolDescripcion" name="rolDescripcion">
                        </div>
                    </div>
                    <input id="accion" name="accion" value="nuevo" type="hidden">
                    <div class="modal-footer  bg-dark">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" onclick="guardarCambiosNuevo()">Agregar</button>
                    </div>
                </div>
            </form>
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
                        <input type="hidden" id='idRolEditar' name="idRolEditar">
                        <div class="mb-3">
                            <label for="rolDescripcionEditar" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="rolDescripcionEditar" name="rolDescripcionEditar">
                        </div>
                    </div>
                    <input id="accionEditar" name="accionEditar" value="editar" type="hidden">
                    <input id="rolDeshabilitadoEditar" name="rolDeshabilitadoEditar" type="hidden">
                    <div class="modal-footer  bg-dark">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" onclick="guardarCambiosEditar()">Guardar Cambios</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    <script src="./js/funcionesAmbRoles.js"></script>

    <?php include_once($ESTRUCTURA . "/pie.php"); ?>
</body>

</html>