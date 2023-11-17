//Modificar Perfil de usuario Logueado
$(document).ready(function () {
  // Evento de clic en el botón "Modificar", usamos la clase para que no sea unico, si usamos id solo tomara el primero
  $(".modificarPerfil").click(function () {
    // Obtener la fila actual del boton
    var fila = $(this).closest("tr");
    // // Obtener datos de las celdas de esa fila
    var idUsuario = fila.find("td:eq(0)").text(); // Ajusta el índice según la posición de la columna
    var usNombre = fila.find("td:eq(1)").text();
    var usMail = fila.find("td:eq(2)").text();
    // Mostrar el modal con los campos llenos
    $("#idUsuario").val(idUsuario); // ids de los campos del modal
    $("#usNombre").val(usNombre);
    $("#usMail").val(usMail);

    $("#editarPerfilModal").modal("show");
  });
});
function guardarCambios() {
  // trae los valores del formulario
  var idUsuario = $("#idUsuario").val();
  var usNombre = $("#usNombre").val();
  var usPass = $("#usPass").val();
  var usMail = $("#usMail").val();
  var accion = $("#accion").val();
  console.log(accion);
  $.ajax({
    type: "POST",
    url: "./accion/accionesPerfil.php",
    data: {
      // envia el siguiente arreglo de datos por post(datos del modal)
      accion: accion,
      idUsuario: idUsuario,
      usNombre: usNombre,
      usPass: usPass,
      usMail: usMail,
    },
    success: function (response) {
      // Maneja la respuesta según tus necesidades (puede ser una confirmación o cualquier otra cosa)
      console.log(response);
      accionSuccess();
    },
    error: function (error) {
      accionFailure();
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
