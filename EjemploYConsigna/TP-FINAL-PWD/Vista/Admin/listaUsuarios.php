<?php
include_once('../estructura/Cabecera.php');
if($objSession->getVista()!=NULL){
    if ($objSession->getVista()->getIdRol() == 1) {
    $objUsuario = new C_Usuario;
    $objUsuarioRol = new C_UsuarioRol;
    $arrayUsers = $objUsuario->buscar(NULL);
    if ($arrayUsers != null) {
        $cantUsers = count($arrayUsers);
        $rolesDesc = $objUsuarioRol->darDescripcionRoles($arrayUsers);
    } else {
        $cantUsers = -1;
    }
    $i = 0;
?>

<div class="container-fluid mx-auto m-5">
    <?php
    if ($cantUsers > -1) {
    ?>
        <div class="mb-3 text-center">
            <a class="btn text-decoration-none btn btn-outline-light" href="registrarse.php">NUEVO USUARIO</a>
        </div>
        <div class="rounded p-3 mb-2 bg-dark text-white">
            <table class="table table-dark table-hover p-5">
                <thead class="text-center">
                    <tr>
                        <th scope="col-4">USUARIO</th>
                        <th scope="col-4">NOMBRE</th>
                        <th scope="col-4">MAIL</th>
                        <th scope="col-4">ROL</th>
                        <th scope="col-6">DESHABILITADO</th>
                        <th scope="col-6">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($i < $cantUsers) {
                    ?>
                        <tr>
                            <th scope="row" class="text-center"><?php echo $i + 1 ?></th>
                            <td><?php echo $arrayUsers[$i]->getUsNombre() ?></td>
                            <td> <?php echo $arrayUsers[$i]->getUsMail() ?> </td>
                            <td> <?php $msn = "-";
                                    foreach ($rolesDesc[$i] as $rol) {
                                        $msn = $msn . $rol . "-";
                                    }
                                    echo $msn ?>
                            </td>
                            <td class="text-center"> <?php echo $arrayUsers[$i]->getUsDeshabilitado() == NULL ? "NO" : $arrayUsers[$i]->getUsDeshabilitado(); ?> </td>
                            <td>
                                <form method='post' action='actualizarLogin.php' id="'<?php echo $arrayUsers[$i]->getIdUsuario() ?>">
                                    <input style="display:none;" name='idUsuario' id='idUsuario' value='<?php echo $arrayUsers[$i]->getIdUsuario() ?>'>
                                    <button type="submit" class="ms-3 text-decoration-none btn btn-outline-warning"> EDITAR </button>
                                    <?php echo $arrayUsers[$i]->getUsDeshabilitado() == NULL ?
                                        "<button type='button' class='mx-2 text-decoration-none btn btn-outline-danger deshabilitar'>
                        DESHABILITAR
                        </button>" :
                                        "<button type='button' class='mx-2 text-decoration-none btn btn-outline-danger habilitar'>
                        HABILITAR
                        </button>";
                                    ?>

                                </form>
                            </td>
                        </tr>
                    <?php
                        $i++;
                    } ?>
                </tbody>
            </table>
        </div>
    <?php
    } else {
    ?>
        <div class="alert alert-warning" role="alert">
            No existen usuarios cargados...
        </div>
    <?php
    }
    ?>
</div>
<script src="js/deshabilitarUsuarios.js"></script>
<?php
    }else{
        header('Location: ../paginas/home.php');
    }
}else{
    header('Location: ../paginas/home.php');
}
include_once("../estructura/Pie.php")
?>