<?php
include_once("../../config.php");
$pagSeleccionada = "Gestionar Usuarios";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once($ESTRUCTURA . "/header.php"); ?>
    <?php include_once($ESTRUCTURA . "/cabeceraBD.php"); ?>
</head>

<body>
    <div class="mt-2 container cajaLista">
        <h1>Usuarios</h1>
    </div>
    <?php
    $objUsuario = new AbmUsuario;
    $objRolUsuario = new AbmUsuarioRol;
    $objRol = new AbmRol;

    $listadoRoles = $objRol->buscar(null);
    $listaUsuarios = $objUsuario->buscar(null);
    $listadoRolesYusuarios = $objRolUsuario->buscar(null);
    //pruebas julian
    // $objUs=$objSession->getUsuario(); 
    // $idUs= $objUs->getIdUsuario(); 
    // $param["idUsuario"]= $idUs;
    // $listadoRolesSegunUsuario= $objRolUsuario->buscar($param);

    // print_r($listaObjsRolesDelUsuario);

    // print_r($listadoRolesSegunUsuario);
    // print_r($_SESSION);
    // print_r($objUs);
    // $param["idRol"]=;
    // $listadoRolesUsuarioActual = $objRol->buscar();
    ?>
    <div class="container text-center p-4 mt-3 cajaLista">
        <h2>Lista de usuarios </h2>
        <div class="table-responsive">

            <table class="table m-auto">
                <thead class="table-dark fw-bold">
                    <tr>
                        <td>Nombre Usuario</td>
                        <td>Password</td>
                        <td>Mail</td>
                        <td>Estado</td>
                        <td>Rol</td>
                        <td colspan="8">Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($listaUsuarios) > 0) {
                        foreach ($listaUsuarios as $user) {
                            echo '<tr><td>' . $user->getUsNombre() . '</td>';
                            echo '<td>' . $user->getUsPass() . '  </td>';
                            echo '<td>' . $user->getUsMail() . '  </td>';
                            if ($user->getUsDeshabilitado() == null) {
                                echo '<td>Activo</td>';
                            } else {
                                echo '<td>Baja desde: ' . $user->getUsDeshabilitado() . '  </td>';
                            }
                            //Inicio modificacion Marco 

                            echo '<td>';
                            foreach ($listadoRoles as $roles) {
                                foreach ($listadoRolesYusuarios as $rolesUsuarios) {
                                    $objUsuario = $rolesUsuarios->getObjUsuario();
                                    $objRol = $rolesUsuarios->getObjRol();
                                    $roles->getIdRol();
                                    $user->getIdUsuario();
                                    if ($objRol->getIdRol() ==  $roles->getIdRol() && $objUsuario->getIdUsuario() == $user->getIdUsuario()) {
                                        // echo '<td>' . $roles->getRolDescripcion() . '</td>';
                                        echo " " . $roles->getRolDescripcion() . " ";
                                    }
                                }
                            }
                            echo '</td>';
                            echo "<td>";
                            if ($user->getUsDeshabilitado() == null) {
                                echo '<a class="btn btn-danger mx-1 eliminar" href="' . $VISTA . '/action/abmUsuarios.php?accion=borrar&idUsuario=' . $user->getIdUsuario() . '">Dar baja</a>';
                            } else {
                                echo '<a class="btn btn-success mx-1" darAlta href="' . $VISTA . '/action/abmUsuarios.php?accion=alta&idUsuario=' . $user->getIdUsuario() . '">Dar de alta</a>';
                            }
                            //Fin modificacion Marco
                            echo '<button type="button mx-1" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarModal" data-bs-id=' . $user->getIdUsuario() . '>Editar</button>';
                            echo "</td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
    <!-- <div class="my-3 text-center ">
        llamara ala modal de cargar nuevo
        <button class="btn btn-success"data-bs-toggle="modal"  data-bs-target="#nuevoModal">Cargar Usuario Nuevo</button>
    </div> -->

    <!-- Modal Nuevo 
    <div class="modal fade" id="nuevoModal" tabindex="-1" aria-labelledby="nuevoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form name="nuevoForm" id="nuevoForm" method="post" action="<?php echo $VISTA; ?>/accion/usuarios/nuevoUsuario.php">
            <form name="nuevoForm" id="nuevoForm" method="post" action="./accion/nuevoUsuario.php">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-light">
                        <h1 class="modal-title fs-5" id="editarModalLabel">Nuevo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id='id' name="idUsuario">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="usNombre">
                        </div>
                        <div class="mb-3">
                            <label for="mail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="mail" name="usMail">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="usPass">
                        </div>
                        Inicio Modificacion de Marco
                        <div class="mb-3">
                            <select class="form-select" aria-label="Default select example" name="idRol" id="idRol">
                                <option selected>Seleciona un Rol</option>
                                <option value="1">Admin</option>
                                <option value="2">Cliente</option>
                                <option value="3">Deposito</option>
                            </select>
                        </div>
                        fin Modificacion de Marco
                        <input id="accion" name="accion" value="nuevo" type="hidden">
                    </div>
                    <div class="modal-footer  bg-dark">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    </div>
                </div>
            </form>
        </div>
    </div> -->

    <!-- Modal editar -->
    <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form name="editarForm" id="editarForm" method="post" action="<?php echo $VISTA; ?>/accion/usuarios/editarUsuario.php">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-light">
                        <h1 class="modal-title fs-5" id="editarModalLabel">Editar</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id='id' name="idUsuario">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="usNombre">
                        </div>
                        <div class="mb-3">
                            <label for="mail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="mail" name="usMail">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="usPass">
                        </div>
                        <!-- Inicio Modificacion de Marco -->
                        <div class="mb-3">
                            <select class="form-select" aria-label="Default select example" name="idRol" id="idRol">
                                <option selected>Seleciona un Rol</option>
                                <option value="1">Admin</option>
                                <option value="2">Cliente</option>
                                <option value="3">Deposito</option>
                            </select>
                        </div>
                        <!-- fin Modificacion de Marco -->
                        <input id="accion" name="accion" value="editar" type="hidden">
                    </div>
                    <div class="modal-footer  bg-dark">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php include_once($ESTRUCTURA . "/pie.php"); ?>
</body>

</html>