@if (!Session::get('email'))
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
    <title>Admin TheFork</title>
    <link rel="stylesheet" href="css/style_home_admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;500&display=swap" rel="stylesheet">
    <script src="js/ajaxAdmin.js"></script>
    <link rel="shortcut icon" href="../public/img/icono.png">
</head>

<body>

    <header>
        <div class="row" id="section1">
            <div class="one-column-s1">
                <a href="{{ url('ayuda2')}}">
                    <p><b style="padding-right: 10px;" onclick="">AYUDA</b></p>
                </a>
            </div>
            <div class="one-column-s1">
                <p><b> | </b></p>
            </div>
            <div class="one-column-s1">
                <a href="{{ url('logout')}}">
                    <p><b>CERRAR SESIÓN</b></p>
                </a>
            </div>
        </div>
        <div class="row" id="section2">
            <img src="../public/img/theforklogo.jpg" alt="logo" width="10%" style="padding: 5px 0px 5px 20px">
        </div>
    </header>
    
    <div class="row" id="section3">
        <div class="filtro">
            <div>
                <form action="{{url("crear")}}" method="get">
                    <input type="submit" value="Crear restaurante">
                </form>
            </div>
            <br>
            <div>
            <!--Formulario filtro AJAX por nombre-->
                <form method="post" onsubmit="return false;">
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre..." style="width: 45%" onkeyup="filtro();return false;">
                </form>
            </div>
        </div>
    </div>

    <div class="row" id="section4">
        <div class="one-column-s4">
            <h2 style="padding-left: 40px">¡Bienvenido ADMIN!</h2>
        </div>
    </div>

    <div class="row" id="restaurants">
        <div class="one-column-res">
            @if($restaurantlist != null)
                @foreach ($restaurantlist as $restaurant)
                    <div class="box-res" onclick="window.location.href='{{url('home_admin/restaurant_admin/'.$restaurant->id)}}'">
                        <div class="three-column-res">
                            <img width="276px" height="216px" src="{{asset('storage').'/'.$restaurant->imagen_general}}">
                        </div>
                        <div class="three-column-res">
                            <p><b>{{$restaurant->nombre}}</b></p>
                            <p>{{$restaurant->direccion}}</p>
                        </div>   
                        <div class="three-column-res">
                            <button onclick="window.location.href='{{url('home-adm/update/'.$restaurant->id)}}'">Actualizar Restaurante</button>
                            <button onclick="window.location.href='{{url('home-adm/delete/'.$restaurant->id)}}'">Eliminar Restaurante</button>
                        </div>
                    </div>
                @endforeach
            @else
            <h1>No se han encontrado elementos</h1>
            @endif
        </div>
    </div>


    <footer>
        <div class="row" id="footer1">
                <div class="one-column-footer">
                    <div class="two-column-footer">
                        <p style="padding-left: 70px; font-weight:100">Guia de restaurantes</p>
                    </div>
                    <div>
                        <p style="padding-left: 20px;">Los 10 mejores restaurantes de Barcelona</p>  
                    </div>
                    
                </div>
        </div>

        <div class="row" id="footer2">
            <div class="four-column-footer">
                <h3 style="font-weight:500">Descargar aplicación</h3>
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
                <p>© 2022 LA FOURCHETTE SAS - TODOS LOS DERECHOS RESERVADOS</p>
            </div>
        </div>

        <div class="row" id="footer2">
            <center>
                <div class="one-column-footer">
                    <p style="text-align: center; font-size: .88rem; padding: 0px 5% 0px 5%; font-weight:100">Las ofertas promocionales están sujetas a las condiciones que figuran en la página del restaurante. Las ofertas en bebidas alcohólicas están dirigidas únicamente a adultos. El consumo excesivo de alcohol es perjudicial para la salud.
                        Bebe con moderación.
                    </p>
                </div>
            </center>
        </div>
    </footer>

</body>

</html>