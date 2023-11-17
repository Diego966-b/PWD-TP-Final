$(document).ready(function () {
  // Evento de clic en el botón que abre el modal
  $("#abrirModal").click(function () {
    $("#miModal").modal("show");
  });
  $("#miFormularioNuevo").submit(function (event) {
    event.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
      type: "POST",
      url: "./accion/accionesArticulos.php?accion=nuevo",
      data: formData,
      success: function (response) {
        accionSuccess();
      },
      error: function (error) {
        alert("Error en la solicitud AJAX:", error);
      },
    });
    // Cerrar el modal después de enviar el formulario
    $("#miModal").modal("hide");
  });
});

//Modificar
$(document).ready(function () {
  // Evento de clic en el botón "Modificar"
  $(".btn-modificar").click(function () {
    // Obtener la fila actual
    var fila = $(this).closest("tr");
    // Obtener datos de las celdas de esa fila
    var idProducto = fila.find("td:eq(0)").text();
    var proNombre = fila.find("td:eq(1)").text();
    var proDetalle = fila.find("td:eq(2)").text();
    var proImagen = fila.find("td:eq(3)").text();
    var proStock = fila.find("td:eq(4)").text();
    var proPrecio = fila.find("td:eq(5)").text();
    // Llenar el modal con los datos capturados
    $("#proIdModificar").val(idProducto);
    $("#proNombreModificar").val(proNombre);
    $("#proDetalleModificar").val(proDetalle);
    $("#proImagenModificar").val(proImagen);
    $("#proCantStockModificar").val(proStock);
    $("#proPrecioModificar").val(proPrecio);
    // Mostrar el modal
    $("#modalModificar").modal("show");
  });
});

function guardarCambios() {
  var idProducto = $("#proIdModificar").val();
  var nombreProducto = $("#proNombreModificar").val();
  var detalleProducto = $("#proDetalleModificar").val();
  var imagenProducto = $("#proImagenModificar").val();
  var stockProducto = $("#proCantStockModificar").val();
  var precioProducto = $("#proPrecioModificar").val();

  $.ajax({
    type: "POST",
    url: "./accion/accionesArticulos.php?accion=editar",
    data: {
      idProducto: idProducto,
      proNombre: nombreProducto,
      proDetalle: detalleProducto,
      proImagen: imagenProducto,
      proCantStock: stockProducto,
      proPrecio: precioProducto,
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

function eliminarArticulo(idProducto) {
  console.log("entro");
  $.ajax({
    type: "POST",
    url: "./accion/accionesArticulos.php?accion=borrar",
    data: {
      idProducto: idProducto,
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

function altaArticulo(idProducto) {
  $.ajax({
    type: "POST",
    url: "./accion/accionesArticulos.php?accion=alta",
    data: {
      idProducto: idProducto,
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
