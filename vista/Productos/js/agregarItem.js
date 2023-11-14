function agregarItemCarrito(idProducto, proImagen, proPrecio, proDetalle, proNombre, proCantStock){
    console.log(idProducto);
    //var proCantidad = $(".proCantidad").val();
    var proCantidad = $("#proCantidad-" + idProducto).val();

    //var fila = $(this).closest("input");
    console.log("cantidad:"+proCantidad);
    $.ajax({
        type: "POST",
        url: "./accion/accionAgregarItem.php", // Crea este archivo para procesar la solicitud
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
