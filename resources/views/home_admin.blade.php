@if (!Session::get('email')||Session::get('rol') != "Admin")
    <?php
        //Si la session no esta definida te redirige al login, la session se crea en el método.
        return redirect()->to('/')->send();
    ?>
@endif

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
    <title>FOOTER P3</title>
    <link rel="stylesheet" href="css/style_home_admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100&display=swap" rel="stylesheet">
    <script src="js/ajaxAdmin.js"></script>
    <link rel="shortcut icon" href="../public/img/icono.png">
</head>

<body>
<form action="{{url("crear")}}" method="get">
    <input type="submit" value="crear">
</form>
  <!--Formulario filtro AJAX por nombre-->
  <form method="post" onsubmit="return false;">
    <input type="text" name="nombre" id="nombre" onkeyup="filtro();return false;">
  </form>
  <table id="restaurants">
    <tr>
        <th>Nombre</th>
        <th>Direccion</th>
        <th>Imagen general</th>
    </tr>
    @if($restaurantlist != null)
        @foreach ($restaurantlist as $restaurant)
        <tr>
            <td>{{$restaurant->nombre}}</td>
            <td>{{$restaurant->direccion}}</td>
            <td><img src="{{asset('storage').'/'.$restaurant->imagen_general}}"></td>
            <td><button onclick="window.location.href='{{url('home-adm/update/'.$restaurant->id)}}'">Actualizar Restaurante</button></td>
            <td><button onclick="window.location.href='{{url('home-adm/delete/'.$restaurant->id)}}'">Eliminar Restaurante</button></td>
        </tr>
        @endforeach
    @else
    <h1>No se han encontrado elementos</h1>
    @endif
</table>
    <footer>
        <div class="row" id="footer1">
            <div class="one-column-footer">
                <p style="padding-left: 4.5%;">Guia de restaurantes <b style="padding-left: 20px;">Los 10 mejores restaurantes de Barcelona</b></p>

            </div>
        </div>

        <div class="row" id="footer2">
            <div class="four-column-footer">
                <h3>Descargar aplicación</h3>
                <p><img src="../public/img/applestore.png" alt="applestore"></p>
                <p><img src="../public/img/playstore.png" alt="googleplay"></p>
            </div>

            <div class="four-column-footer">
                <b>
                    <p>¿Quiénes somos?</p>
                    <p>Información de contacto</p>
                    <p>¿Tienes un restaurante?</p>
                    <p>Preguntas frecuentes</p>
                    <p>Trabaja con nosotros</p>
                    <p>Colaboración Guia MICHELIN</p>
                </b>

            </div>

            <div class="four-column-footer">
                <b>
                    <p>Programa Yums</p>
                    <p>Condiciones de uso</p>
                    <p>Declaración de Privacidad y Cookies</p>
                    <p>Aceptación de cookies</p>
                    <p>Blog</p>
                    <p>Tarjeta Regalo TheFork</p>                    
                </b>

            </div>

            <div class="four-column-footer">
                <p><img src="../public/img/instagram.png" alt="instagram" width="25px"><img src="../public/img/facebook.png" alt="facebook" width="38px" style="padding-left: 10px;"></p>
                <p><b>© 2022 LA FOURCHETTE SAS - TODOS LOS DERECHOS RESERVADOS</b></p>
            </div>
        </div>

        <div class="row" id="footer2">
            <center>
                <div class="one-column-footer">
                    <p style="text-align: center; font-size: .88rem; padding: 0px 5% 0px 5%;">Las ofertas promocionales están sujetas a las condiciones que figuran en la página del restaurante. Las ofertas en bebidas alcohólicas están dirigidas únicamente a adultos. El consumo excesivo de alcohol es perjudicial para la salud.
                        Bebe con moderación.
                    </p>
                </div>
            </center>
        </div>
    </footer>

</body>

</html>