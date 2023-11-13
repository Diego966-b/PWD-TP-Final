
//Modificar
$(document).ready(function() {
    // Evento de clic en el botón "Modificar", usamos la clase para que no sea unico, si usamos id solo tomara el primero
    $(".btn-modificar").click(function() {
        // Obtener la fila actual del boton
        var fila = $(this).closest("tr");
        // Obtener datos de las celdas de esa fila
        var idRol = fila.find("td:eq(0)").text(); // Ajusta el índice según la posición de la columna
        var rolDescripcion = fila.find("td:eq(1)").text();
        var rolDeshabilitado = null;
        console.log(idRol);
        console.log(rolDescripcion);
        console.log(rolDeshabilitado);
        
        // Llenar el modal con los datos capturados
        $("#idRolEditar").val(idRol);// ids de los campos del modal
        $("#rolDescripcionEditar").val(rolDescripcion);
        $("#rolDeshabilitadoEditar").val(rolDeshabilitado);
       
        // Mostrar el modal con los campos llenos
        $("#editarModal").modal("show");
    });
});




function guardarCambiosNuevo() {
    // trae los valores del formulario
    var accion =$("#accion").val();
    var idRol =$("#idRol").val();
    var rolDescripcion = $("#rolDescripcion").val();

    $.ajax({
        type: "POST",
        url: "./accion/accionesRoles.php", // Asegúrate de crear este archivo para eliminar el producto
        data: {
            // envia el siguiente arreglo de datos por post(datos del modal)
            accion:accion,
            idRol: idRol,
            rolDescripcion:  rolDescripcion,
        },
        success: function(response) {
            // Maneja la respuesta según tus necesidades (puede ser una confirmación o cualquier otra cosa)
            console.log(response);
            // Elimina la fila de la tabla (puedes hacerlo directamente aquí o recargar la página)
            // Recargar la página después de actualizar el usuario
            accionSuccess();
        },
        error: function(error) {
            console.error("Error en la solicitud AJAX:", error);
        }
    });
}


function guardarCambiosEditar() {
    // trae los valores del formulario
    var accion =$("#accionEditar").val();
    var idRol =$("#idRolEditar").val();
    var rolDescripcion = $("#rolDescripcionEditar").val();
    var rolDeshabilitado = null;
    console.log(rolDeshabilitado);
    


    $.ajax({
        type: "POST",
        url: "./accion/accionesRoles.php", // Asegúrate de crear este archivo para eliminar el producto
        data: {
            // envia el siguiente arreglo de datos por post(datos del modal)
            accion: accion,
            idRol: idRol,
            rolDescripcion:  rolDescripcion,
            rolDeshabilitado: rolDeshabilitado,
        },
        success: function(response) {
            // Maneja la respuesta según tus necesidades (puede ser una confirmación o cualquier otra cosa)
            console.log(response);
            // Elimina la fila de la tabla (puedes hacerlo directamente aquí o recargar la página)
            // Recargar la página después de actualizar el usuario
            accionSuccess();
        },
        error: function(error) {
            console.error("Error en la solicitud AJAX:", error);
        }
    });
}



function eliminarRol(idRol) {
    console.log("entro");
    // Realiza la solicitud AJAX para eliminar el producto
    $.ajax({
        type: "POST",
        url: "./accion/accionesRoles.php?accion=borrar", // Asegúrate de crear este archivo para eliminar el producto
        data: {
            idRol: idRol
        },
        success: function(response) {
            // Maneja la respuesta según tus necesidades (puede ser una confirmación o cualquier otra cosa)
            console.log(response);
            // Elimina la fila de la tabla (puedes hacerlo directamente aquí o recargar la página)
            // Puedes recargar la página después de eliminar el producto
            accionSuccess();
        },
        error: function(error) {
            accionFailure();
            console.error("Error en la solicitud AJAX:", error);
        }
    });
}

function altaRol(idRol){
    $.ajax({
        type: "POST",
        url: "./accion/accionesRoles.php?accion=alta", // Asegúrate de crear este archivo para eliminar el producto
        data: {
            idRol: idRol
        },
        success: function(response) {
            // Maneja la respuesta según tus necesidades (puede ser una confirmación o cualquier otra cosa)
            console.log(response);
            // Elimina la fila de la tabla (puedes hacerlo directamente aquí o recargar la página)
            // Puedes recargar la página después de eliminar el producto
            accionSuccess();
        },
        error: function(error) {
            accionFailure();
            console.error("Error en la solicitud AJAX:", error);
        }
    });
}

// mensaje de error y succcess
function accionSuccess() {
    Swal.fire({
        icon: 'success',
        title: 'La accion se realizo correctamente!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function(){
        location.reload();
    },1500);
}

function accionFailure() {
    Swal.fire({
        icon: 'error',
        title: 'No se ha realizado la accion!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function(){
        location.reload();
    },1500);
}