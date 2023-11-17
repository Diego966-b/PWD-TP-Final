function eliminarCompra(idCompra, idCompraEstado) {
  $.ajax({
    type: "POST",
    url: "./accion/accionesUsuario.php?accion=bajaCompra", // Asegúrate de crear este archivo para eliminar el producto
    data: {
      idCompra: idCompra,
      idCompraEstado: idCompraEstado,
    },
    success: function (response) {
      console.log(response);
      location.reload();
    },
    error: function (error) {
      console.error("Error en la solicitud AJAX:", error);
    },
  });
}
