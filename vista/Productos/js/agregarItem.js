<<<<<<< HEAD
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
                alert("Producto agregado al carrito");
                console.log(data);
            },
            error: function(error) {
                console.error("Error en la solicitud AJAX:", error);
            }
        });
    }
=======
function agregarItemCarrito(idProducto){
 var proCantidad = $(".proCantidad").val();
    $.ajax({        
        type: "POST",
        url: "./accion/accionAgregarItem.php", // Crea este archivo para procesar la solicitud
        data: { 
            idProducto: idProducto,
            proCantidad : proCantidad,
        },
        success: function(response){
            console.log(response);
            alert("Producto agregado al carrito");
        },
        error: function(error) {
            console.error("Error en la solicitud AJAX:", error);
        }
    });
>>>>>>> marco
}
