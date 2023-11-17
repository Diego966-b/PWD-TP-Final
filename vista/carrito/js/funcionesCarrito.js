function eliminarUnidad (idProducto){
    console.log(idProducto);
    $.ajax({
        type: "POST",
        url: "./accion/eliminarUnidad.php",
        data: { 
            idProducto: idProducto
        },
        success: function(response) {
            accionSuccess(); 
        },
        error: function(error) {
            console.error("Error en la solicitud AJAX:", error);
        }
    });
}

function pagarCarrito() {
    $.ajax({
        type: "POST",
        url: "./accion/pagarCarrito.php",
        data: { 
            carrito: carrito
        },
        success: function(response) {
            accionSuccess(); 
        },
        error: function(error) {
            console.error("Error en la solicitud AJAX:", error);
        }
    });
}

function accionSuccess() {
    Swal.fire({
        icon: 'success',
        title: 'La accion se realizo correctamente!',
        showConfirmButton: false,
        timer: 2000
    })
    setTimeout(function(){
        location.reload();
    },2000);
}

function accionFailure() {
    Swal.fire({
        icon: 'error',
        title: 'No se ha realizado la accion!',
        showConfirmButton: false,
        timer: 2000
    })
    setTimeout(function(){
        location.reload();
    },2000);
}