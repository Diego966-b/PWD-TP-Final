
function eliminarCompra(idCompra, idCompraEstado){
   

   console.log("idCompra: " +idCompra);
   console.log("IdCompraEstado:" + idCompraEstado);
 
        $.ajax({
            type: "POST",
            url: "./accion/accionesUsuario.php?accion=bajaCompra", // Asegúrate de crear este archivo para eliminar el producto
            data: {
               idCompra : idCompra,
               idCompraEstado : idCompraEstado,         
            },
            success: function(response) {
                // Maneja la respuesta según tus necesidades (puede ser una confirmación o cualquier otra cosa)
                console.log(response);
                location.reload();
                // Elimina la fila de la tabla (puedes hacerlo directamente aquí o recargar la página)
                // Recargar la página después de actualizar el usuario
                
            },
            error: function(error) {
                console.error("Error en la solicitud AJAX:", error);
            }
        });
}


