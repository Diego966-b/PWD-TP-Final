function pagarCarrito() {
    for (var i = 0; i < carrito.length; i++) {
        var producto = carrito[i];
        console.log(producto);
        console.log("ID Producto: " + producto.idProducto);
        console.log("Pro Cantidad: " + producto.proCantidad);
    }

    $.ajax({
        type: "POST",
        url: "./accion/pagarCarrito.php",
        data: { 
            carrito: carrito
        },
        success: function(response) {
            accionSuccess(); 
            /*         
            setTimeout(function () {
                location.reload();
            }, 100);
            */
        },
        error: function(error) {
            console.error("Error en la solicitud AJAX:", error);
        }
    });
}

function accionSuccess() {
    Swal.fire({
        icon: 'success',
        title: 'La accion se realizo correctamente!',
        showConfirmButton: false,
        timer: 2000
    })
    setTimeout(function(){
        location.reload();
    },2000);
}

function accionFailure() {
    Swal.fire({
        icon: 'error',
        title: 'No se ha realizado la accion!',
        showConfirmButton: false,
        timer: 2000
    })
    setTimeout(function(){
        location.reload();
    },2000);
}












function agregarUnidad(idProducto, proCantidad){

    $.ajax({
        type: "POST",
        url: "./accion/accionAgregarItem.php", 
        data: { 
            idProducto: idProducto,
            proCantidad: proCantidad,
        },
        success: function(response){
            alert("Agregue 1 unidad");
        },
        error: function(error) {
            console.error("Error en la solicitud AJAX:", error);
        }
    });
}
function eliminarUnidad(idProducto, proCantidad){
    $.ajax({
        type: "POST",
        url: "./accion/eliminarUnidad.php",
        data: { 
            idProducto: idProducto,
            proCantidad: proCantidad,
        },
        success: function(response){
            alert("Elimine 1 unidad");
            actualizarCantidad(idProducto);
        },
        error: function(error) {
            console.error("Error en la solicitud AJAX:", error);
        }
    });
}

function actualizarCantidad(idProducto)
{
    // Evento clic para el botón de actualizar
    console.log(idProducto);
    //$(".btnRestar").click(function() {
    // Obtener el valor actual de proCantidad
    var cantidadActual = parseInt($("#proCantidad-"+idProducto).text(), 10);
    
    // Disminuir la cantidad en 1
    var nuevaCantidad = cantidadActual - 1;
    console.log(nuevaCantidad);
    // Realizar la solicitud AJAX para actualizar la cantidad en el servidor
    $.ajax({
        url: 'carrito.php',
        type: 'POST',
        data: { nuevaCantidad: nuevaCantidad },
        success: function(response) {
            // Actualizar el valor en el frontend si la actualización fue exitosa
            $("#proCantidad-"+idProducto).text(nuevaCantidad);
        },
        error: function(error) {
            console.error('Error en la solicitud AJAX:', error);
        }
    });
//});
}


/*
inputUno = document.getElementById("numeroUno")
inputDos = document.getElementById("numeroDos")
botonSumar = document.querySelector(".botonSumar")
parrafo = document.querySelector(".parrafo")

botonSumar.addEventListener('click', suma)
function suma() {
    let numeroUno = inputUno.value
    let numeroDos = inputDos.value
    let resultado = Number.parseInt(numeroUno) + Number.parseInt(numeroDos)
    parrafo.innerHTML = resultado
}
*/