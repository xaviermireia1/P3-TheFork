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
    <title>TheFork</title>
    <link rel="stylesheet" href="css/style_home.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <script src="js/ajaxHome.js"></script>
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


    <!--Formulario filtro AJAX por nombre-->
    <div class="row" id="section3">
        <div class="filtro">
            <form method="post" onsubmit="return false;">
                <input type="text" name="nombre" id="nombre" placeholder="Nombre..." onkeyup="filtro();return false;">
                <!--Formulario filtro AJAX por tipo cocina-->
                <select name="tipo_cocina" id="tipo_cocina" onchange="filtro();return false;">
                    <option value="">Tipo de cocina</option>
                    @foreach($cooktypes as $cooktype)
                        <option value="{{$cooktype->tipo_cocina}}">{{$cooktype->tipo_cocina}}</option>
                    @endforeach
                </select>
                <!--Formulario filtro AJAX por tipo likes-->
                <select name="likes" id="likes" onchange="filtro();return false;">
                    <option value="">Valoración</option>
                    <option value="likes">Más likes</option>
                    <option value="dislikes">Menos likes</option>
                </select>
                <!--Formulario filtro AJAX por tipo likes-->
                <select name="precio_medio" id="precio_medio" onchange="filtro();return false;">
                    <option value="">Precio</option>
                    <option value="caro">Más caro</option>
                    <option value="barato">Más barato</option>
                </select>
            </form>
        </div>
    </div>

    <div class="row" id="section4">
        <div class="one-column-s4">
            <h2 style="padding-left: 40px">Los mejores restaurantes de Barcelona</h2>
        </div>
    </div>

    <div class="row" id="restaurants">
        <div class="one-column-res">
            @if($restaurantlist != null)
                @foreach ($restaurantlist as $restaurant)
                    <div style="cursor: pointer" class="box-res" onclick="window.location.href='{{url('home/restaurant/'.$restaurant->id)}}'">
                        <div class="three-column-res">
                            <img width="400px" height="250px" src="{{asset('storage').'/'.$restaurant->imagen_general}}">
                        </div>

                        <div class="three-column-res" style="padding-left: 100px">
                            <p>{{$restaurant->tipo_cocina}}</p>
                            <p><b>{{$restaurant->nombre}}</b></p>
                            <p>{{$restaurant->direccion}}</p>
                            <p style="color: rgb(212, 0, 0)">Precio medio: {{$restaurant->precio_medio}}€</p>
                        </div>

                        <div class="three-column-res">
                            @if ($restaurant->likes == 0 || $restaurant->likes == null)
                                <p style="font-size: 20px">0 <i class="fas fa-heart"></i></p>
                                
                            @else
                                <p style="font-size: 20px">{{$restaurant->likes}} <i class="fas fa-heart" style="color: red"></i></p>
                                
                            @endif
                        </div>
                    </div>
                @endforeach
                
            @else
            <h2 style="padding: 0px 0px 10px 20vh">No se han encontrado elementos</h2>
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
                <p><img src="../public/img/applestore.png" alt="applestore" style="cursor: pointer"></p>
                <p><img src="../public/img/playstore.png" alt="googleplay" style="cursor: pointer"></p>
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
