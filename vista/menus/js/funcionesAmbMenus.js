//Modificar
$(document).ready(function () {
  // Evento de clic en el botón "Modificar", usamos la clase para que no sea unico, si usamos id solo tomara el primero
  $(".btn-modificar").click(function () {
    // Obtener la fila actual del boton
    var fila = $(this).closest("tr");
    // Obtener datos de las celdas de esa fila
    var idMenu = fila.find("td:eq(0)").text(); // Ajusta el índice según la posición de la columna
    var meNombre = fila.find("td:eq(1)").text();
    var meDescripcion = fila.find("td:eq(2)").text();
    var meDeshabilitado = null;
    console.log(idMenu);
    console.log(meNombre);
    console.log(meDescripcion);
    console.log(meDeshabilitado);

    // Llenar el modal con los datos capturados
    $("#idMenuEditar").val(idMenu); // ids de los campos del modal
    $("#meNombreEditar").val(meNombre);
    $("#meDescripcionEditar").val(meDescripcion);
    $("#meDeshabilitadoEditar").val(meDeshabilitado);

    // Mostrar el modal con los campos llenos
    $("#editarModal").modal("show");
  });
});
//Modificar Roles
$(document).ready(function () {
  // Evento de clic en el botón "Modificar", usamos la clase para que no sea unico, si usamos id solo tomara el primero
  $(".btn-modificarRoles").click(function () {
    // Obtener la fila actual del boton
    var fila = $(this).closest("tr");
    // Obtener datos de las celdas de esa fila
    var idMenu = fila.find("td:eq(0)").text(); // Ajusta el índice según la posición de la columna
    // var meNombre = fila.find("td:eq(1)").text(); // Ajusta el índice según la posición de la columna
    console.log(idMenu);
    // console.log(meNombre);
    $("#menuMod").val(idMenu); // ids de los campos del modal

    $("#editarRolesModal").modal("show");
  });
});

function guardarCambiosRoles() {
  var accion = $("#accionRoles").val();
  var idMenu = $("#menuMod").val();
  var rolesSeleccionados = [];
  console.log(idMenu);
  console.log(accion);

  $("input[type=checkbox]:checked").each(function () {
    rolesSeleccionados.push($(this).val());
  });
  console.log(rolesSeleccionados);
  $.ajax({
    type: "POST",
    url: "./accion/accionesRoles.php", // Asegúrate de crear este archivo para eliminar el producto
    data: {
      // envia el siguiente arreglo de datos por post(datos del modal)
      accion: accion,
      idMenu: idMenu,
      rolesSeleccionados: rolesSeleccionados,
    },
    success: function (response) {
      // Maneja la respuesta según tus necesidades (puede ser una confirmación o cualquier otra cosa)
      console.log(response);
      // Elimina la fila de la tabla (puedes hacerlo directamente aquí o recargar la página)
      // Recargar la página después de actualizar el usuario
      Swal.fire({
        icon: "success",
        title: "La accion se realizo correctamente!",
        showConfirmButton: false,
        timer: 1500,
      });
      location.reload();
    },
    error: function (error) {
      accionFailure();
      console.error("Error en la solicitud AJAX:", error);
    },
  });
}

function guardarCambiosNuevo() {
  // trae los valores del formulario
  var accion = $("#accion").val();
  var meNombre = $("#meNombre").val();
  var meDescripcion = $("#meDescripcion").val();
  var idPadre = $("#idMenuPadre").val();

  $.ajax({
    type: "POST",
    url: "./accion/accionesMenus.php", // Asegúrate de crear este archivo para eliminar el producto
    data: {
      // envia el siguiente arreglo de datos por post(datos del modal)
      accion: accion,
      meNombre: meNombre,
      meDescripcion: meDescripcion,
      idPadre: idPadre,
    },
    success: function (response) {
      // Maneja la respuesta según tus necesidades (puede ser una confirmación o cualquier otra cosa)
      console.log(response);
      // Elimina la fila de la tabla (puedes hacerlo directamente aquí o recargar la página)
      // Recargar la página después de actualizar el usuario
      accionSuccess();
      location.reload(2000);
    },
    error: function (error) {
      accionFailure();
      console.error("Error en la solicitud AJAX:", error);
    },
  });
}

function guardarCambiosEditar() {
  // trae los valores del formulario
  var accion = $("#accionEditar").val();
  var idMenu = $("#idMenuEditar").val();
  var meNombre = $("#meNombreEditar").val();
  var meDescripcion = $("#meDescripcionEditar").val();
  var idPadre = $("#idMenuPadreEditar").val();
  var meDeshabilitado = null;

  $.ajax({
    type: "POST",
    url: "./accion/accionesMenus.php", // Asegúrate de crear este archivo para eliminar el producto
    data: {
      // envia el siguiente arreglo de datos por post(datos del modal)
      accion: accion,
      idMenu: idMenu,
      meNombre: meNombre,
      idPadre: idPadre,
      meDescripcion: meDescripcion,
      meDeshabilitado: meDeshabilitado,
    },
    success: function (response) {
      // Maneja la respuesta según tus necesidades (puede ser una confirmación o cualquier otra cosa)
      console.log(response);
      // Elimina la fila de la tabla (puedes hacerlo directamente aquí o recargar la página)
      // Recargar la página después de actualizar el usuario
      accionSuccess();
    },
    error: function (error) {
      console.error("Error en la solicitud AJAX:", error);
    },
  });
}

function eliminarMenu(idMenu) {
  console.log("entro");
  // Realiza la solicitud AJAX para eliminar el producto
  $.ajax({
    type: "POST",
    url: "./accion/accionesMenus.php?accion=borrar", // Asegúrate de crear este archivo para eliminar el producto
    data: {
      idMenu: idMenu,
    },
    success: function (response) {
      // Maneja la respuesta según tus necesidades (puede ser una confirmación o cualquier otra cosa)
      console.log(response);
      // Elimina la fila de la tabla (puedes hacerlo directamente aquí o recargar la página)
      // Puedes recargar la página después de eliminar el producto
      accionSuccess();
    },
    error: function (error) {
      accionFailure();
      console.error("Error en la solicitud AJAX:", error);
    },
  });
}

function altaMenu(idMenu) {
  $.ajax({
    type: "POST",
    url: "./accion/accionesMenus.php?accion=alta", // Asegúrate de crear este archivo para eliminar el producto
    data: {
      idMenu: idMenu,
    },
    success: function (response) {
      // Maneja la respuesta según tus necesidades (puede ser una confirmación o cualquier otra cosa)
      console.log(response);
      // Elimina la fila de la tabla (puedes hacerlo directamente aquí o recargar la página)
      // Puedes recargar la página después de eliminar el producto
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
