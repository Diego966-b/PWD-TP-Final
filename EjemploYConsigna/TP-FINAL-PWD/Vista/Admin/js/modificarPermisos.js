    $('#formModificarPermiso').submit(function (e) {
        e.preventDefault();
        const forms = document.querySelectorAll('.needs-validation');
            if (forms[0].checkValidity()) {
                $.ajax({
                    type: "POST",
                    url: 'Accion/modificarPermiso.php',
                    data: $(this).serialize(),
                    success: function (response) {
                        var jsonData = JSON.parse(response);
                        // user is logged in successfully in the back-end
                        // let's redirect
                        if (jsonData.success == "3"){
                            modificadoSuccess("Rol y datos");
                        }else if (jsonData.success == "2"){
                            modificadoSuccess("Datos del menu");
                        }else if(jsonData.success == "1"){
                            //solo modifico roles: Rol agregado con exito!
                            modificadoSuccess("Rol")
                        }else if(jsonData.success == "0"){
                            modificadoFailure();
                        }
                    }
                });
            } else {
            forms[0].classList.add('was-validated');
        }
    });


function modificadoSuccess(string){
    Swal.fire({
        icon: 'success',
        title: `${string} modificados con exito!`,
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
        location.href="gestionarPermisos.php";
    }, 1500);
}

function modificadoFailure() {
    Swal.fire({
        icon: 'error',
        title: 'No se modificó ningún dato',
        showConfirmButton: false,
        timer: 1500
    })
}
