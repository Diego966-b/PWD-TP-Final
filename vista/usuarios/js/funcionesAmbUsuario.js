//Modificar usuarios
$(document).ready(function () {
  // Evento de clic en el botón "Modificar", usamos la clase para que no sea unico, si usamos id solo tomara el primero
  $(".btn-modificar").click(function () {
    // Obtener la fila actual del boton
    var fila = $(this).closest("tr");
    // Obtener datos de las celdas de esa fila
    var idUsuario = fila.find("td:eq(0)").text(); // Ajusta el índice según la posición de la columna
    var usNombre = fila.find("td:eq(1)").text();
    var usPass = fila.find("td:eq(2)").text();
    var usMail = fila.find("td:eq(3)").text();
    // Llenar el modal con los datos capturados
    $("#idUsuario").val(idUsuario); // ids de los campos del modal
    $("#usNombre").val(usNombre);
    // $("#usPass").val(usPass);
    $("#usMail").val(usMail);
    // Mostrar el modal con los campos llenos
    $("#editarModal").modal("show");
  });
});

function guardarCambios() {
  // trae los valores del formulario
  var idUsuario = $("#idUsuario").val();
  var usNombre = $("#usNombre").val();
  var usPass = $("#usPass").val();
  var usMail = $("#usMail").val();
  var idRol = $("#idRol").val();
  $.ajax({
    type: "POST",
    url: "./accion/accionesUsuario.php?accion=editar",
    data: {
      // envia el siguiente arreglo de datos por post(datos del modal)
      idUsuario: idUsuario,
      usNombre: usNombre,
      usPass: usPass,
      usMail: usMail,
      idRol: idRol,
    },
    success: function (response) {
      console.log(response);
      accionSuccess();
    },
    error: function (error) {
      console.error("Error en la solicitud AJAX:", error);
    },
  });
}

function eliminarUsuario(idUsuario) {
  console.log("entro");
  // Realiza la solicitud AJAX para eliminar el producto
  $.ajax({
    type: "POST",
    url: "./accion/accionesUsuario.php?accion=borrar",
    data: {
      idUsuario: idUsuario,
    },
    success: function (response) {
      console.log(response);
      accionSuccess();
    },
    error: function (error) {
      accionFailure();
      console.error("Error en la solicitud AJAX:", error);
    },
  });
}

function altaUsuario(idUsuario) {
  $.ajax({
    type: "POST",
    url: "./accion/accionesUsuario.php?accion=alta",
    data: {
      idUsuario: idUsuario,
    },
    success: function (response) {
      console.log(response);
      accionSuccess();
    },
    error: function (error) {
      accionFailure();
      console.error("Error en la solicitud AJAX:", error);
    },
  });
}

// mensaje de error y succcess
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
