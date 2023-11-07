<?php
include_once('../estructura/Cabecera.php');
if($objSession->getVista()!=NULL){
    if ($objSession->getVista()->getIdRol() == 1) {
        $datos=data_submitted();
        $objUsuario=new C_Usuario();
        $objUsuarioRol=new C_UsuarioRol();
        $objRol=new C_Rol();
        $roles=$objRol->buscar(null);
        $usuarioModificar=$objUsuario->buscar($datos);
        $descRolesUsuario=$objUsuarioRol->darDescripcionRoles($usuarioModificar);
?>
<div class="container-md mb-5">
<main class="w-50 m-auto mt-5 text-center">
    <form class="row gy-2 text-center justify-content-center rounded bg-dark text-white needs-validation" novalidate>
    <div class="col-10" style="display:none;">
        <label for="floatingInput" class="form-label mt-2">ID</label>
        <input type="number" class="form-control" 
                name="idUsuario" id="idUsuario" value="<?php echo $usuarioModificar[0]->getIdUsuario()?>">
    </div>
    <div class="col-10 col-lg-7">
        <label for="floatingInput" class="form-label mt-2">NOMBRE DE USUARIO</label>
        <input type="text" class="form-control" placeholder="Username" pattern="[a-zA-Z]+\s?[0-9]*" minlength="3"
                name="usNombre" id="usNombre" value="<?php echo $usuarioModificar[0]->getUsNombre()?>" required>
                <div class="invalid-feedback">
                    Porfavor ingrese un nombre valido! No se aceptan numeros y tiene que ser mayor a 3 letras.
                </div>
                <div class="valid-feedback">
                    Correcto!
                </div>
    </div>
    <div class="col-10 col-lg-7">
    <label for="usNombre" class="form-label mt-2">MAIL</label>
        <input type="text" class="form-control" placeholder="Mail" pattern="^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*\.([a-z]{3})(\.[a-z]{2})*$"
                name="usMail" id="usMail" value="<?php echo $usuarioModificar[0]->getUsMail()?>" required>
    </div>
    <div class="col-10 col-lg-7">
    <label for="usPass" class="form-label mt-2">CONTRASEÑA</label>
        <input type="password" class="form-control" placeholder="***********" id="usPassNueva">
        <input type="password" class="form-control d-none"
            id="usPassAnterior" value="<?php echo $usuarioModificar[0]->getUsPass()?>">
            <div class="invalid-feedback">
                    Porfavor ingrese un email válido.
                </div>
                <div class="valid-feedback">
                    Correcto!
                </div>
    </div>
    <div class="col-8 col-lg-7 mt-4">
        <h6 class="text-center mb-3">ROLES</h6>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" checked disabled>
            <label class="form-check-label" for="user">
                CLIENTE
            </label>
        </div>
        <div class="form-check d-none">
            <input class="form-check-input" type="checkbox" value="2" name="rol[]" checked>
            <label class="form-check-label" for="user">
                CLIENTE
            </label>
        </div>
            <?php
             foreach($roles as $rol){
                if($rol->getRolDescripcion()!='CLIENTE'){
                    ?>
                    <div class="form-check">
                    <input class='form-check-input' type='checkbox' name='rol[]' value='<?php echo $rol->getIdRol() ?>'
                    <?php
                        foreach($descRolesUsuario[0] as $rolUsuario){
                            if($rolUsuario==$rol->getRolDescripcion()){
                                ?>checked
                                <?php
                            }
                        }
                    ?>
                    >
                    <label class='form-check-label' for='admin'><?php echo $rol->getRolDescripcion() ?> </label>
                    </div>
                    <?php
                }
            }
            ?>
    </div>
    <button class="btn btn-lg btn-success my-3 col-10 col-lg-7 mt-4">MODIFICAR</button>
    </form>
</main>
</div>
<script src="../js/validarCamposVacios.js"></script>
<script src="js/mainActualizarLogin.js"></script>
<script src="../js/md5.js"></script>
<?php
    }else{
        header('Location: ../paginas/home.php');
    }
}else{
    header('Location: ../paginas/home.php');
}
include_once("../estructura/Pie.php")
?>