$(document).ready(function() {
    $.validator.addMethod("soloLetras", function(value, element) {
        return this.optional(element) || /^[a-zA-Z\sáéíóúÁÉÍÓÚñÑüÜ]+$/i.test(value);
    }, "Solo se permiten letras en este campo");
    $("#editarForm").validate({
        rules: {
            usNombre: {
                required: true,
                soloLetras: true,
            },
            usMail: {
                required: true,
            },
            usPass: {
                required: true,
            },
            
        },
        messages: {
            usNombre: {
                required: "Este campo es requerido",
            },
            usMail: {
                required: "Este campo es requerido",
            },
            usPass: {
                required: "Este campo es requerido",
            },
        },
        errorElement: "div", // Cambia el elemento utilizado para mostrar mensajes de error a 'div'
        errorClass: "text-danger", // Clase de Bootstrap para el color de texto rojo
        errorPlacement: function(error, element) 
        {   
            error.insertAfter(element);   
        }   
    });
});

