function compraRealizada() {
    Swal.fire({
        icon: 'success',
        title: 'El producto se ha comprado correctamente!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
        recargarPagina();
    }, 1500);
}

function compraFallida() {
    Swal.fire({
        icon: 'error',
        title: 'No se ha podido realizar la compra el producto!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
        recargarPagina();
    }, 1500);
}

function noexisteproducto() {
    Swal.fire({
        icon: 'error',
        title: 'No tienes productos en el carrito todavia!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
        recargarPagina();
    }, 1500);
}

function recargarPagina() {
    location.reload();
}

$(document).on('click', '#iniciar_compra', function() {
    let idCompraEstado = document.getElementById("idCompraEstado").childNodes[0].nodeValue
    $.ajax({
        type: "POST",
        url: 'Accion/accionRealizarCompraCarrito.php',
        data: {idCompraEstado:idCompraEstado},
        
        success: function (respuesta) {
            var jsonData = JSON.parse(respuesta);

            // user is logged in successfully in the back-end
            // let's redirect
            if (jsonData.success == "1") {
                compraRealizada();
            }
            else if (jsonData.success == "0") {
                compraFallida();
            } 
            else if (jsonData.success == "2") {
                noexisteproducto();
            } 
        }
    });
});