function eliminarItem(idCompraItem, idCompra) {
  $.ajax({
    type: "POST",
    url: "./accion/actualizarCompraItem.php",
    data: {
        idCompraItem: idCompraItem,
        idCompra: idCompra,
    },
    success: function (response) {
      accionSuccess();
    },
    error: function (error) {
      console.log("Error:", error);
    },
  });
}
function enviarDatos(idCompra, ultimoIdCompraEstado) {
  var idCompraEstadoTipo = $("#estado-" + idCompra).val();
  $.ajax({
    type: "POST",
    url: "./accion/actualizarEstado.php",
    data: {
      idCompraEstado: ultimoIdCompraEstado,
      idCompraEstadoTipo: idCompraEstadoTipo,
      idCompra: idCompra,
    },
    success: function (response) {
      accionSuccess();
    },
    error: function (error) {
      console.log("Error:", error);
    },
  });
}

function accionSuccess() {
  Swal.fire({
    icon: "success",
    title: "La accion se realizo correctamente!",
    showConfirmButton: false,
    timer: 1500,
  });
  setTimeout(function () {
    location.reload();
  }, 1500);
}

function accionFailure() {
  Swal.fire({
    icon: "error",
    title: "No se ha realizado la accion!",
    showConfirmButton: false,
    timer: 1500,
  });
  setTimeout(function () {
    location.reload();
  }, 1500);
}
