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
}
