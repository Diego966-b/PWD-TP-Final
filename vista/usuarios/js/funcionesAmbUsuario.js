function darBajaUsuario(){

}
// mensaje de error y succcess
function registerSuccess() {
    Swal.fire({
        icon: 'success',
        title: 'El producto se ha eliminado correctamente!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
        recargarPagina();
    }, 1500);
}

function registerFailure() {
    Swal.fire({
        icon: 'error',
        title: 'No se ha podido eliminar el producto!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
        recargarPagina();
    }, 1500);
}