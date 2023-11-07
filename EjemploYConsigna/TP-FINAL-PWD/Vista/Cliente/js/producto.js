/**************************************/
/************* CARRITO ****************/
/**************************************/

$(document).on('click', '#logo_carrito', function() {
    let totalCompra, sumaTot, tabla
    tabla = document.getElementById("lista__carrito");
    totalCompra = document.getElementById("total-Compra");
    sumaTot = 0;
    for (i = 1; i < tabla.rows.length; i++) {
        sumaTot += parseInt(tabla.rows[i].cells[3].innerHTML * tabla.rows[i].cells[4].innerHTML);
    }
    totalCompra.innerHTML = "Precio Total: $ " + sumaTot;
});

/**************************************/
/************* DETALLE ****************/
/**************************************/
function verDetalle(datos) {
    let imagenInfo, nombreInfo, descripcionInfo, precioInfo, cantidadInfo, cantidadInput, idProductoInput;
    imagenInfo = document.getElementById("foto__detalle");
    nombreInfo = document.getElementById("nombre__detalle");
    descripcionInfo = document.getElementById("descripcion__detalle");
    precioInfo = document.getElementById("precio__detalle");
    cantidadInfo = document.getElementById("cantidad_detalle");
    cantidadInput = document.getElementById("cantidad_input");
    idProductoInput = document.getElementById("idProducto");
    imagenInfo.src = datos.children[0].children[0].children[0].src;
    nombreInfo.innerHTML = datos.children[0].children[1].children[0].childNodes[0].nodeValue;
    descripcionInfo.innerHTML = datos.children[0].children[1].children[1].childNodes[0].nodeValue;
    precioInfo.innerHTML = "Precio: $ " + datos.children[0].children[1].children[2].childNodes[0].nodeValue;
    cantidadInfo.innerHTML = "Cantidad de Stock: " + datos.children[0].children[1].children[3].childNodes[0].nodeValue;
    cantidadInput.setAttribute("max", datos.children[0].children[1].children[3].childNodes[0].nodeValue);
    idProductoInput.value = datos.children[0].children[1].children[4].childNodes[0].nodeValue;
}

/**************************************/
/************* FILTER *****************/
/**************************************/

function filtrar(textFilter) {
    let tarjetas;
    tarjetas = document.getElementsByClassName("tarjetas-productos");
    for (i = 0; i < tarjetas.length; i++) {
        console.log(tarjetas[i].textContent.toLocaleLowerCase().includes(textFilter.toLowerCase()))
        if (tarjetas[i].textContent.toLocaleLowerCase().includes(textFilter.toLowerCase())) {
            tarjetas[i].classList.remove("filter");
        } else {
            tarjetas[i].classList.add("filter");
        }
    }
}

/**************************************/
/************* COMPRAR ****************/
/**************************************/
function redireccionarPaginaInicio() {
    location.href = 'index.php'
}

function confirmarCompra() {
    let tabla = document.getElementById("lista__carrito");
    if (tabla.rows.length > 1) {
        if (localStorage.getItem("inicio") == "si") {
            Swal.fire({
                icon: 'success',
                title: 'Su compra fue confirmada correctamente!',
                showConfirmButton: false,
                timer: 1500
            })
            setTimeout("redireccionarPaginaInicio()", 1450);
        }else{
            Swal.fire({
                title: 'No tienes cuenta!',
                text: "Desea crear una?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si'
              }).then((result) => {
                if (result.isConfirmed) {
                    location.href= "registrarse.php"
                }
              })
        }
    } else {
        Swal.fire({
            icon: 'error',
            title: 'No hay elementos en el carrito!',
            showConfirmButton: false,
            timer: 1500
        })
    }
}