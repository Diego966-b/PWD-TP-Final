<?php
include_once('../estructura/Cabecera.php');
if($objSession->getVista()!=NULL){
    if ($objSession->getVista()->getIdRol() == 1) {
        $datos=data_submitted();
        $objMenu=new C_Menu();
        $objMenuRol=new C_MenuRol();
        $objRol=new C_Rol();
        $menuModificar=$objMenu->buscar($datos);
        $rolModificar=$objMenuRol->buscar($datos);
        $roles=$objRol->buscar(null);
        $permisos=$objMenuRol->buscar(null);

?>


<div class="container-md">
<main class="w-50 m-auto mt-5 text-center">
    <form class="row gy-2 text-center justify-content-center rounded bg-dark text-white needs-validation my-5" 
        id="formModificarPermiso" method="post" action="../Accion/modificarPermiso.php" novalidate>
    <div class="col-10" style="display:none;">
        <label for="floatingInput" class="form-label mt-2">ID</label>
        <input type="number" class="form-control" 
                name="idMenu" value="<?php echo $menuModificar[0]->getIdMenu()?>">
    </div>
    <div class="col-10 col-lg-7">
        <label for="meNombre" class="form-label mt-2">Nombre de Menu</label>
        <input type="text" class="form-control" pattern="[a-zA-Z]+\s?[a-zA-Z]*\s?[a-zA-Z]*\s?[a-zA-Z]*\s?[a-zA-Z]*"
                name="meNombre" value="<?php echo $menuModificar[0]->getMeNombre()?>" required>
    </div>
    <div class="col-10 col-lg-7">
                
                <label class="form-label mt-2">Menu Padre</label>
                <select name="idPadre" class="form-select" aria-label=".form-select example">
                <option value="" selected >Seleccionar</option>
                <?php
                foreach($permisos as $permiso){
                    ?>
                    <option value="<?php echo $permiso->getMenu()->getIdMenu()?>"> <?php echo $permiso->getMenu()->getMeNombre()?></option>
                    <?php
                }
                ?>
                </select>
                
            </div>
    <div class="col-10 col-lg-7">
    <label for="meDescripcion" class="form-label mt-2">Ruta Relativa</label>
        <input type="text" class="form-control" pattern="(..\/)([a-zA-Z0-9_\-]+)(\/[a-zA-Z0-9_\-]+)\.php"
                name="meDescripcion" value="<?php echo $menuModificar[0]->getMeDescripcion()?>" required>
    </div>
    <div class="col-8 col-lg-7 mt-4">
        <label>Rol que puede acceder</label>
                <select name="idRol" class="form-select mb-3" aria-label=".form-select example" required>
                <option value="<?php echo $rolModificar[0]->getRol()->getIdRol() ?>" selected><?php echo $rolModificar[0]->getRol()->getRolDescripcion() ?></option>
                <?php
                foreach($roles as $rol){
                    if($rol->getRolDescripcion()!=$rolModificar[0]->getRol()->getRolDescripcion()){
                    ?>
                    <option value="<?php echo $rol->getIdRol() ?>"><?php echo $rol->getRolDescripcion() ?> </option>
                    <?php
                    }
                }
                ?>
                </select>
    </div>
    <button class="btn btn-lg btn-success my-3 col-10 col-lg-7 mt-4">MODIFICAR</button>
    </form>
</main>
</div>
<script src="js/modificarPermisos.js"></script>
<?php
    }else{
        header('Location: ../paginas/home.php');
    }
}else {
    header('Location: ../paginas/home.php');
}
include_once("../estructura/Pie.php")
?>