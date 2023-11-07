$(document).on('click', '.deshabilitar', function() {
    const form=$(this.parentNode);
    console.log(form);
    mostrarAdvertencia(form);
}
)

function mostrarAdvertencia(form){
    Swal.fire({
        title: 'Realmente quiere deshabilitar el menu?',
        showDenyButton: true,
        confirmButtonText: 'Si',
        denyButtonText: `Cancelar`,
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          deshabilitarMenu(form);
        } else if (result.isDenied) {
          Swal.fire('El menu no fue deshabilitado', '', 'info')
        }
      })
}

function deshabilitarMenu(form){
    $.ajax({
        type: "POST",
        url: 'Accion/deshabilitarMenu.php',
        data: form.serialize(),
        success: function(response){
            var jsonData = JSON.parse(response);
            // user is logged in successfully in the back-end
            // let's redirect
            if (jsonData.success == "1"){
                deshabilitarSuccess();
            }
            else if (jsonData.success == "0"){
                deshabilitarFailure();
            }
       }
   });
}

function deshabilitarSuccess(){
    Swal.fire({
        icon: 'success',
        title: 'Se deshabilito el menu correctamente!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function(){
        location.reload();
    },1500);
}

function deshabilitarFailure(){
    Swal.fire({
        icon: 'error',
        title: 'El menu no pudo ser deshabilitado',
        showConfirmButton: false,
        timer: 1500
    })
}


$(document).on('click', '.habilitar', function() {
    const form=$(this.parentNode);
    mostrarAdvertenciaHabilitar(form);
}
)

function mostrarAdvertenciaHabilitar(form){
    Swal.fire({
        title: 'Realmente quiere volver a habilitar el menu?',
        showDenyButton: true,
        confirmButtonText: 'Si',
        denyButtonText: `Cancelar`,
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          habilitarMenu(form);
        } else if (result.isDenied) {
          Swal.fire('El menu no fue habilitado', '', 'info')
        }
      })
}


function habilitarMenu(form){
    $.ajax({
        type: "POST",
        url: 'Accion/habilitarMenu.php',
        data: form.serialize(),
        success: function(response){
            var jsonData = JSON.parse(response);
            // user is logged in successfully in the back-end
            // let's redirect
            if (jsonData.success == "1"){
                habilitarSuccess();
            }
            else if (jsonData.success == "0"){
                habilitarFailure();
            }
       }
   });
}

function habilitarSuccess(){
    Swal.fire({
        icon: 'success',
        title: 'Se habilito el menu correctamente!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function(){
        location.reload();
    },1500);
}

function habilitarFailure(){
    Swal.fire({
        icon: 'error',
        title: 'No se pudo habilitar el menu',
        showConfirmButton: false,
        timer: 1500
    })
}