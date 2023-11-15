$(document).ready(function() {
    $.validator.addMethod("soloLetras", function(value, element) {
        return this.optional(element) || /^[a-zA-Z\sáéíóúÁÉÍÓÚñÑüÜ]+$/i.test(value);
    }, "Solo se permiten letras en este campo");

    // Registro

    $("#registrarForm").validate({
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
                soloLetas: "Solo se permiten letras en este campo",
            },
            usMail: {
                required: "Este campo es requerido",
            },
            usPass: {
                required: "Este campo es requerido",
            },
        },
        errorElement: "div", 
        errorClass: "text-danger", 
        errorPlacement: function(error, element) 
        {   
            error.insertAfter(element);   
        }   
    });

    // Login

    $("#loginForm").validate({
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
                soloLetas: "Solo se permiten letras en este campo",
            },
            usMail: {
                required: "Este campo es requerido",
            },
            usPass: {
                required: "Este campo es requerido",
            },
        },
        errorElement: "div", 
        errorClass: "text-danger", 
        errorPlacement: function(error, element) 
        {   
            error.insertAfter(element);   
        }   
    });

    // Productos

    $("#formProductos").validate({
        rules: {
            proCantidad: {
                required: true,
            },
        },
        messages: {
            proCantidad: {
                required: "Este campo es requerido",
            },
        },
        errorElement: "div", 
        errorClass: "text-danger", 
        errorPlacement: function(error, element) 
        {   
            error.insertAfter(element);   
        } 
    });

});