$(document).ready(function () {
    $('form').submit(function (e) {
        e.preventDefault();
        const forms = document.querySelectorAll('.needs-validation');
        if (forms[0].checkValidity()) {
            $.ajax({
                type: "POST",
                url: 'Accion/accionCargarProductoCarrito.php',
                data: $(this).serialize(),
                success: function (response) {
                    var jsonData = JSON.parse(response);

                    // user is logged in successfully in the back-end
                    // let's redirect
                    if (jsonData.success == "1") {
                        cargaExitosa();
                    }
                    else if (jsonData.success == "0") {
                        cargaFallida();
                    }
                }
            });
        } else {
            forms[0].classList.add('was-validated');
        }
    });
});


function cargaExitosa() {
    Swal.fire({
        icon: 'success',
        title: 'El producto se cargo exitosamente al carrito!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
        recargarPagina();
    }, 1500);
}

function cargaFallida() {
    Swal.fire({
        icon: 'error',
        title: 'El producto no se ha podido cargar al carrito ya que no hay stock suficiente!',
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
