$(document).on('click', '#ver_productos_compras', function () {
    limpiarTabla("lista__carrito");
    var fila = $(this).closest('tr');
    let timerInterval
    Swal.fire({
        title: 'Buscando Productos!',
        timer: 500,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading()
            const b = Swal.getHtmlContainer().querySelector('b')
            timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
            }, 500)
        },
        willClose: () => {
            clearInterval(timerInterval)
        }
    }).then((result) => {
        /* Read more about handling dismissals below */
        if (result.dismiss === Swal.DismissReason.timer) {
        }
    })
    $.ajax({
        type: "POST",
        url: '../Accion/accionVerProductosMisCompras.php',
        data: { idCompra: fila[0].children[0].innerHTML },

        success: function (respuesta) {
            var jsonData = JSON.parse(respuesta);
            // user is logged in successfully in the back-end
            // let's redirect
            if (Array.isArray(jsonData.success)) {
                let tabla = document.getElementById("lista__carrito");
                for (let producto of jsonData.success) {
                    let fila = tabla.insertRow(tabla.rows.length);
                    let celda0 = fila.insertCell(0);
                    let celda1 = fila.insertCell(1);
                    let celda2 = fila.insertCell(2);
                    let celda3 = fila.insertCell(3);
                    let celda4 = fila.insertCell(4);
                    celda0.className = "col-md-2 urlImagen_tabla"
                    celda1.className = "nombre_tabla"
                    celda2.className = "detalle_tabla"
                    celda3.className = "precio_tabla"
                    celda4.className = "cantidad_tabla"
                    celda0.innerHTML = '<img src="'+producto.UrlImagen+'" class="img-thumbnail"></img>';
                    celda1.innerHTML = producto.Nombre;
                    celda2.innerHTML = producto.Descripcion;
                    celda3.innerHTML = producto.Precio;
                    celda4.innerHTML = producto.Cantidad;
                }
            }
            else if (jsonData.success == "0") {
                registerFailure();
            }
        }
    });
});


function registerFailure() {
    Swal.fire({
        icon: 'error',
        title: 'El producto no se pudo mostrar!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
        recargarPagina();
    }, 1500);
}

function limpiarTabla(nombreTabla) {
    let tabla = document.getElementById(nombreTabla);
    let cantColumnas = tabla.rows.length;
    if (cantColumnas > 1) {
        for (let i = 1; i < cantColumnas; i++) {
            tabla.deleteRow(1);
        }
    }
}
