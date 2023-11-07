$(document).ready(function() {
    $('form').submit(function(e) {
        e.preventDefault();

        let contra=document.querySelector('#usPassAnterior').value;
        let contraNueva=document.querySelector('#usPassNueva').value;
        if(contraNueva.length>0){
            contraNueva = hex_md5(contraNueva).toString();
            document.querySelector('#usPassNueva').value = contraNueva;
            document.querySelector('#usPassNueva').name='usPass';
        }else{
            document.querySelector('#usPassAnterior').value=contra;
            document.querySelector('#usPassAnterior').name='usPass';
        }

        $.ajax({
            type: "POST",
            url: 'Accion/loginActualizado.php',
            data: $(this).serialize(),
            success: function(response){
                var jsonData = JSON.parse(response);
 
                // user is logged in successfully in the back-end
                // let's redirect
                if (jsonData.success == "1"){
                    datosSuccess();
                }else if(jsonData.success =='2'){
                    rolesSuccess();
                }else if(jsonData.success =='3'){
                    ambosSuccess();
                }else if (jsonData.success == "0"){
                    failure();
                }
           }
       });
    });
});

function datosSuccess(){
    Swal.fire({
        icon: 'success',
        title: 'Datos modificados con exito!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function(){
        redireccionarListado();
    },1500);
}


function redireccionarListado() {
    location.href = "listaUsuarios.php"
}

function rolesSuccess(){
    Swal.fire({
        icon: 'success',
        title: 'Roles modificados con exito!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function(){
        redireccionarListado();
    },1500);
}

function ambosSuccess(){
    Swal.fire({
        icon: 'success',
        title: 'Rol y datos modificados con exito!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function(){
        redireccionarListado();
    },1500);
}

function failure(){
    Swal.fire({
        icon: 'error',
        title: 'No se modificaron datos',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function(){
        redireccionarListado();
    },1500);
}