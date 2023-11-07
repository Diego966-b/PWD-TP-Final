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

function recargarPagina() {
    location.reload();
}
var cantidadBorrar;
$(document).on('click', '.eliminar_producto_carrito', function () {

    var fila = $(this).closest('tr');
    var img = fila[0].children[0].children[0].src;

    Swal.fire({
        title: '¿Estás seguro de que desea eliminar este producto?',
        imageUrl: img,
        showDenyButton: true,
        input: 'range',
        inputLabel: 'Elija la cantidad de productos que desea eliminar del carrito',
        inputAttributes: {
            min: 1,
            max: fila[0].children[4].innerHTML,
            step: 1
        },
        inputValue: 1,
        confirmButtonText: 'Eliminar',
        denyButtonText: 'Cancelar',

    }).then((result) => {

        if (result.isConfirmed) {

            eliminar(fila[0].children[5].childNodes[0].nodeValue, result.value);

        } else if (result.isDenied) {

        }
    })


});

function eliminar(idCompraItem, cantidad) {

    $.ajax({
        type: "POST",
        url: 'Accion/accionEliminarProductoCarrito.php',
        data: { idCompraItem: idCompraItem,
                ciCantidad: cantidad},

        success: function (respuesta) {
            var jsonData = JSON.parse(respuesta);

            // user is logged in successfully in the back-end
            // let's redirect
            if (jsonData.success == "1") {
                registerSuccess();
            }
            else if (jsonData.success == "0") {
                registerFailure();
            }
        }
    });

};