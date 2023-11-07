$(document).on('click', '#ver_historial', function () {
    limpiarTabla("seguimiento_compra");
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
        url: '../Accion/accionVerHistorial.php',
        data: { idCompra: fila[0].children[0].innerHTML },

        success: function (respuesta) {
            var jsonData = JSON.parse(respuesta);
            // user is logged in successfully in the back-end
            // let's redirect
            if (Array.isArray(jsonData.success)) {
                let tabla = document.getElementById("seguimiento_compra");
                for (let compra of jsonData.success) {
                    let fila = tabla.insertRow(tabla.rows.length);
                    let celda0 = fila.insertCell(0);
                    let celda1 = fila.insertCell(1);
                    let celda2 = fila.insertCell(2);
                    let celda3 = fila.insertCell(3);
                    let celda4 = fila.insertCell(4);
                    celda0.innerHTML = compra.idCompra;
                    celda1.innerHTML = compra.NombreUsuario;
                    celda2.innerHTML = compra.Estado;
                    celda3.innerHTML = compra.FechaInicio;
                    celda4.innerHTML = compra.FechaFin;
                }
            }
            else if (jsonData.success == "0") {
                registerFailure();
            }
        }
    });
});



function estadoAcpetada() {
    Swal.fire({
        icon: 'success',
        title: 'El estado de la compra se modifico correctamente!',
        showConfirmButton: false,
        timer: 1000
    })
    setTimeout(function () {
        recargarPagina();
    }, 800);
}

function estadoError() {
    Swal.fire({
        icon: 'error',
        title: 'El estado de la compra no se pudo modificar!',
        showConfirmButton: false,
        timer: 1000
    })
    setTimeout(function () {
        recargarPagina();
    }, 800);
}

function recargarPagina() {
    location.reload();
}