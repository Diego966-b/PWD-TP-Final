function agregarItemCarrito(idProducto, proImagen, proPrecio, proDetalle, proNombre, proCantStock){

    console.log("idProducto:"+idProducto);
    var proCantidad = $("#proCantidad-" + idProducto).val();
    var errorContainer = $("#error-proCantidad-" + idProducto);

    // Limpiar mensajes de error previos
    errorContainer.empty();

    // Validacion con jquery:
    if ($.trim(proCantidad) === "" || parseInt(proCantidad) <= 0) {
        var errorMessage = $("<div>").text("La cantidad debe ser un número mayor a 0").addClass("text-danger");
        errorContainer.append(errorMessage);
        event.preventDefault();
    } else {
        console.log("cantidad:"+proCantidad);
        $.ajax({
            type: "POST",
            url: "./accion/accionAgregarItem.php", 
            data: { 
                idProducto: idProducto,
                proCantidad : proCantidad,
                proImagen : proImagen,
                proPrecio : proPrecio,
                proDetalle : proDetalle,
                proNombre : proNombre,
                proCantStock : proCantStock,
            },
            success: function(response){
                accionSuccess();
                console.log(data);
            },
            error: function(error) {
                accionFailure()
                console.error("Error en la solicitud AJAX:", error);
            }
        });
    }
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
