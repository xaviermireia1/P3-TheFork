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
    var tipo_cocina = document.getElementById('tipo_cocina').value;
    var likes = document.getElementById('likes').value;
    var precio_medio = document.getElementById('precio_medio').value;
    console.log(precio_medio);
    //Generamos un formdata que es como mandar datos de formulario de ahí form (formulario), data(datos)
    var formData = new FormData();
    //En el formulario le especificamos el token
    formData.append('_token', token);
    //El metodo que se ejecuta como {{method_field}}
    formData.append('_method', "POST");
    //Y aquí los valores del formulario que en este caso filtramos por nombre y tipo de cocina y por me gusta
    formData.append('nombre', nombre);
    formData.append('tipo_cocina', tipo_cocina);
    formData.append('likes', likes);
    formData.append('precio_medio', precio_medio);
    //Llamamos al Ajax de la funcion de la llamadaAjax
    var ajax = llamadaAjax();
    //Abrimos el ajax mediante la ruta que está en el archivo web, el metodo como pasan los datos que será post y si es asincrono que le decimos que si
    ajax.open("POST", "home/show", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            //Recogemos la respuesta en una variable y parseamos elJSON
            var respuesta = JSON.parse(this.responseText);
            //Varible para recargar la pagina
            var recarga = '';
            if (respuesta.length == 0) {
                recarga += '<h1>No se han encontrado restaurantes</h1>'
            } else {
                //Reconstruimos la pagina
                recarga += '<tr>';
                recarga += '<th>Nombre</th>';
                recarga += '<th>Direccion</th>';
                recarga += '<th>Tipo_cocina</th>';
                recarga += '<th>Imagen general</th>';
                recarga += '<th>Cantidad likes</th>';
                recarga += '<th>Precio medio</th>';
                recarga += '</tr>';
                for (let i = 0; i < respuesta.length; i++) {
                    recarga += '<tr>';
                    recarga += '<td>' + respuesta[i].nombre + '</td>';
                    recarga += '<td>' + respuesta[i].direccion + '</td>';
                    recarga += '<td>' + respuesta[i].tipo_cocina + '</td>';
                    recarga += '<td><img src="storage/' + respuesta[i].imagen_general + '"></td>';
                    if (respuesta[i].likes == null) {
                        recarga += '<td>0</td>';
                    } else {
                        recarga += '<td>' + respuesta[i].likes + '</td>';
                    }
                    recarga += '<td>' + respuesta[i].precio_medio + '</td>';
                    recarga += '</tr>';
                }
            }
            restaurantContent.innerHTML = recarga;
        }
    }
    ajax.send(formData);
}