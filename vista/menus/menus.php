<?php
include_once("../../config.php");
$pagSeleccionada = "Gestionar Menus";
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

<body id="filtro-opacidad">
        <div id="contenido-perfil">
        
            <div>
                <?php
                $objMenu = new AbmMenu;
                $objMenuRol = new AbmMenuRol;
                $objRol = new AbmRol;
                $listadoMenu = $objMenu->buscar(null);
                $listadoRoles = $objRol->buscar(null);
                $listadoRolesYmenu = $objMenuRol->buscar(null);
                ?>
                <div class="container text-center p-4 mt-3 cajaLista">
                    <h2>Lista de Menus </h2>
                    <div class="table-responsive">
                        <table class="table m-auto">
                            <thead class="table-dark fw-bold">
                                <tr>
                                    <td>ID</td>
                                    <td>Nombre</td>
                                    <td>Descripcion</td>
                                    <td>idPadre</td>
                                    <td>Estado</td>
                                    <td>Rol acceso</td>
                                    <td>Acciones</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count($listadoMenu) > 0) {
                                    foreach ($listadoMenu as $menu) {
                                        echo '<tr><td>' . $menu->getIdMenu() . '</td>';
                                        echo '<td>' . $menu->getMeNombre() . '</td>';
                                        echo '<td>' . $menu->getMeDescripcion() . '</td>';
                                        if ($menu->getObjMenu() == null) {
                                            echo '<td>No tiene</td>';
                                        } else {
                                            echo '<td>' . ($menu->getObjMenu()->getIdMenu()) . '</td>';
                                        }
                                        if ($menu->getMeDeshabilitado() == null) {
                                            echo '<td>Activo</td>';
                                        } else {
                                            echo '<td>Baja desde: ' . $menu->getMeDeshabilitado() . '  </td>';
                                        }
                                        echo "<td>";
                                        $tieneRol = false;
                                        foreach ($listadoRolesYmenu as $rolMenu) {
                                            if ($rolMenu->getObjMenu()->getIdMenu() == $menu->getIdMenu()) {
                                                echo $rolMenu->getObjRol()->getRolDescripcion() . " ";
                                                $tieneRol = true;
                                            }
                                        }
                                        if (!$tieneRol) {
                                            echo "Publico";
                                        }
                                        echo "</td>";
                                        echo "<td>";
                                        if ($menu->getMeDeshabilitado() == null) {
                                            echo '<button class="btn btn-danger mx-1 " onclick="eliminarMenu(' . $menu->getIdMenu() . ')">Dar baja</button>';
                                        } else {
                                            echo '<button class="btn btn-success mx-1  " onclick="altaMenu(' . $menu->getIdMenu() . ')">Dar de alta</button>';
                                        }
                                        echo '<button  class="btn btn-primary  mx-1 btn-modificar"  id="modificar"  >Editar</button>';
                                        echo '<button  class="btn btn-primary mx-1 btn-modificarRoles"  id="modificarRoles" >Editar Roles</button>';

                                        echo "</td></tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="text-center m-3">
                    <button type="button" class="btn btn-success btn-nuevo" data-bs-toggle="modal" data-bs-target="#nuevoModal"> Nuevo Menu</button>
                </div>
                                <br><br>
                <!-- modal Editar Roles -->
                <div class="modal fade" id="editarRolesModal" name="editarRolesModal" tabindex="-1" aria-labelledby="nuevoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form name="nuevoform" id="nuevoform" method="post">
                            <div class="modal-content">
                                <div class="modal-header bg-dark text-light">
                                    <h1 class="modal-title fs-5" id="editarModalLabel">Editar Roles del Menu</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-black">
                                    <input type="hidden" name="menuMod" id="menuMod">
                                    <div class="mb-3">
                                        <h3> Roles Disponibles</h3>
                                        <?php
                                        foreach ($listadoRoles as $rol) {
                                            if ($rol->getRolDeshabilitado() == null) {
                                                echo '<input type="checkbox" class="form-check-input" name="rol" id="rol' . $rol->getIdRol() . '" value="' . $rol->getIdRol() . '"> ' . $rol->getRolDescripcion() . '</input> <br>';
                                            } else {
                                                echo '<input type="checkbox" class=" form-check-input" name="rol" disabled id="' . $rol->getIdRol() . '" value="' . $rol->getIdRol() . '">' . $rol->getRolDescripcion() . '</input> Deshabilitado<br>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <input id="accionRoles" name="accionRoles" value="editarRoles" type="hidden">
                                <div class="modal-footer  bg-dark">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-success" onclick="guardarCambiosRoles()">Agregar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Modal Nuevo -->
                <div class="modal fade" id="nuevoModal" name="nuevoModal" tabindex="-1" aria-labelledby="nuevoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form name="nuevoform" id="nuevoform" method="post">
                            <div class="modal-content">
                                <div class="modal-header bg-dark text-light">
                                    <h1 class="modal-title fs-5" id="editarModalLabel">Nuevo Menu</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-black">
                                    <div class="mb-3">
                                        <label for="meNombre" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="meNombre" name="meNombre">
                                    </div>
                                    <div class="mb-3">
                                        <label for="meDescripcion" class="form-label">Descripcion</label>
                                        <input type="text" class="form-control" id="meDescripcion" name="meDescripcion">
                                    </div>
                                    <div class="mb-3">

                                        <label for="idMenuPadre" class="form-label">Id Padre</label>
                                        <select class="form-select" aria-label="Default select example" name="idMenuPadre" id="idMenuPadre">
                                            <option selected value="null">Sin Padre</option>
                                            <?php
                                            foreach ($listadoMenu as $menu) {
                                                echo '<option value="' . $menu->getIdMenu() . '">' . $menu->getMeNombre() . '</option>';
                                            }
                                            ?>
                                        </select>
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
                                <div class="modal-body text-black">
                                    <input type="hidden" id='idMenuEditar' name="idMenuEditar">
                                    <div class="mb-3">
                                        <label for="meNombreEditar" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="meNombreEditar" name="meNombreEditar">
                                    </div>
                                    <div class="mb-3">
                                        <label for="meDescripcionEditar" class="form-label">Descripcion</label>
                                        <input type="text" class="form-control" id="meDescripcionEditar" name="meDescripcionEditar">
                                    </div>
                                    <input id="accionEditar" name="accionEditar" value="editar" type="hidden">
                                    <input id="meDeshabilitadoEditar" name="meDeshabilitadoEditar" type="hidden">
                                    <div class="mb-3">
                                        <label for="idMenuPadreEditar" class="form-label">Id Padre</label>
                                        <select class="form-select" aria-label="Default select example" name="idMenuPadreEditar" id="idMenuPadreEditar">
                                            <option selected value="null">Sin Padre</option>
                                            <?php
                                            foreach ($listadoMenu as $menu) {
                                                echo '<option value="' . $menu->getIdMenu() . '">' . $menu->getMeNombre() . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
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
                                           
    <!--</div>-->

    <script src="./js/funcionesAmbMenus.js"></script>
    <?php include_once($ESTRUCTURA . "/pie.php"); ?>
</body>

</html>