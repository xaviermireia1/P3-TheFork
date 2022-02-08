//Llamada AJAX
function llamadaAjax() {
    var xmlhttp = false;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}

function filtro() {
    //Cogemos lo que se va a recargar
    var restaurantContent = document.getElementById('restaurants');
    //El token lo tenemos en el meta de la pagina de home
    var token = document.getElementById('token').getAttribute("content");
    var nombre = document.getElementById('nombre').value;
    //Generamos un formdata que es como mandar datos de formulario de ahí form (formulario), data(datos)
    var formData = new FormData();
    //En el formulario le especificamos el token
    formData.append('_token', token);
    //El metodo que se ejecuta como {{method_field}}
    formData.append('_method', "POST");
    //Y aquí los valores del formulario que en este caso filtramos por nombre y tipo de cocina y por me gusta
    formData.append('nombre', nombre);
    //Llamamos al Ajax de la funcion de la llamadaAjax
    var ajax = llamadaAjax();
    //Abrimos el ajax mediante la ruta que está en el archivo web, el metodo como pasan los datos que será post y si es asincrono que le decimos que si
    ajax.open("POST", "home-adm/show", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            //Recogemos la respuesta en una variable y parseamos elJSON
            var respuesta = JSON.parse(this.responseText);
            //Varible para recargar la pagina
            var recarga = '';
            console.log(respuesta.length);
            if (respuesta.length == 0) {
                recarga += '<h2 style="padding: 0px 0px 10px 25vh; color: red;">No se han encontrado restaurantes :(</h2>';
            } else {
                //Reconstruimos la pagina
                recarga += '<div class="one-column-res">';
                for (let i = 0; i < respuesta.length; i++) {
                    let urlRest = 'home-adm/restaurant_admin/' + respuesta[i].id;
                    let urlUpd = 'home-adm/update/' + respuesta[i].id;
                    let urlDel = 'home-adm/delete/' + respuesta[i].id;
                    recarga += `<div class="box-res">`;
                    recarga += `<div style="cursor:pointer" class="three-column-res" onclick="window.location.href='` + urlRest + `'">`;
                    recarga += `<img width="276px" height="216px" src="storage/` + respuesta[i].imagen_general + `">`;
                    recarga += `</div>`;
                    recarga += `<div style="cursor:pointer" class="three-column-res" onclick="window.location.href='` + urlRest + `'">`;
                    recarga += '<p><b>' + respuesta[i].nombre + '</b></p>';
                    recarga += '<p>' + respuesta[i].direccion + '</p>';
                    recarga += `</div>`;
                    recarga += '<div class="three-column-res">';
                    recarga += `<button name="actualizar" onclick="window.location.href='` + urlUpd + `'">Actualizar Restaurante</button>`;
                    recarga += `<button name="eliminar" onclick="window.location.href='` + urlDel + `'">Eliminar Restaurante</button>`;
                    recarga += `</div>`;
                    recarga += `</div>`;
                }
            }
            restaurantContent.innerHTML = recarga;
        }
    }
    ajax.send(formData);
}