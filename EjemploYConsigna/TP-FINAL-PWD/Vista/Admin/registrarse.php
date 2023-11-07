<?php
include_once("../estructura/Cabecera.php");
if($objSession->getVista()!=NULL){
    if ($objSession->getVista()->getIdRol() == 1) {
?>
<script src="../js/validarContraseñaIguales.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer> </script>
<script src="../js/md5.js"></script>
<div class="container-fluid">
    <div class="container-md w-50 text-center rounded p-3 mb-2 bg-dark text-white mt-5">
        <form method="post" action="../Accion/accionRegistrarse.php" class="needs-validation row text-white my-4 justify-content-center" novalidate>
            <div class="col-lg-7 col-12 mt-2">
                <label>NOMBRE </label>
                <input type="text" pattern="[a-zA-Z]+\s?[0-9]*" name="usNombre" minlength="3" id="input_nombre" class="form-control text mt-2" required>
                <div class="invalid-feedback">
                    Porfavor ingrese un nombre valido! No se aceptan numeros y tiene que ser mayor a 3 letras.
                </div>
                <div class="valid-feedback">
                    Correcto!
                </div>
            </div>
            <div class="col-lg-7 col-12 mt-2">
                <label>MAIL </label>
                <input type="text" pattern="^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*\.([a-z]{3})(\.[a-z]{2})*$" name="usMail" minlength="3" class="form-control text mt-2" required>
                <div class="invalid-feedback">
                    Porfavor ingrese un email válido.
                </div>
                <div class="valid-feedback">
                    Correcto!
                </div>
            </div>
            <div class="col-lg-7 col-12 mt-2">
                <label>CONTRASEÑA </label>
                <input type="password" id="input_contraseña" class="form-control mt-2" required>
                <input type="password" class="form-control d-none" name="usPass"  id="contraseñaEnviada">
                <div class="invalid-feedback">
                    Ingrese una contraseña!
                </div>
                <div class="invalid-password" style="display: none;">
                    Las contraseñas no coinciden
                </div>
                <div class="valid-feedback password-correcta">
                    Correcto!
                </div>
            </div>
            <div class="col-lg-7 col-12 mt-2">
                <label>REPETIR LA CONTRASEÑA </label>
                <input type="password" id="input_contraseñaRep" class="form-control mt-2" required>
                <div class="invalid-feedback">
                    Ingrese una contraseña!
                </div>
                <div class="invalid-password" style="display: none; color: red;">
                    Las contraseñas no coinciden
                </div>
                <div class="valid-feedback password-correcta">
                    Correcto!
                </div>
            </div>
            <div class="row text-center mx-auto justify-content-center">
                <div class="col-7 text-center mx-auto mx-5">
                    <div class="g-recaptcha m-4" data-sitekey="6Lf95XwiAAAAANd2Ey0ue87QCWiiD6_A17eONhTX"></div>
                </div>
                <input class="btn btn-lg btn-success my-3 col-8 mt-4" type="submit" name="boton_enviar" id="boton_enviar" value="REGISTRARSE">
                <a href="listaUsuarios.php" class="link-info mt-4">VOLVER</a>
            </div>
        </form>
    </div>
</div>
<script src="js/mainRegistrarse.js"></script>
<?php
    }else{
        header('Location: ../paginas/home.php');
    }
}else {
    header('Location: ../paginas/home.php');
}
include_once("../estructura/Pie.php");
?>