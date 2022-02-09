@if (!Session::get('email'))
    <?php
        //Si la session no esta definida te redirige al login, la session se crea en el método.
        return redirect()->to('login')->send();
    ?>
@endif

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/style_restaurant.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!--Alertify-->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css"/>
    <!------------>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <title>TheFork</title>
    <script src="../../js/restaurant.js"></script>
    <link rel="shortcut icon" href="../../../public/img/icono.png">
</head>
<body>

    <header>
        <div class="row" id="section1">
            <div class="one-column-s1-l">
                <a>
                    <p onclick="history.back()" style="cursor: pointer">Back</p>
                </a>
            </div>
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
            <img src="../../../public/img/theforklogo.jpg" alt="logo" width="10%" style="padding: 5px 0px 5px 20px">
        </div>
    </header>
    


    <div class="row" id="restaurants">
        <div class="one-column-res">
            @foreach ($restaurant as $result)

                <div class="one-column-res">
                    @if ($result->likes == 0)
                    <p style="font-size: 25px; float:right">0 <i class="fas fa-heart"></i></p>
                    
                @else
                    <p style="font-size: 25px; float:right">{{$result->likes}} <i class="fas fa-heart" style="color: red"></i></p>
                    
                @endif
                    <p>{{$result->tipo_cocina}}</p>
                    <h2><b>{{$result->nombre}}</b></h2>
                    <p>{{$result->direccion}}<a href="http://maps.google.com/?q={{$result->direccion}}" target="_blank" style="color: green; padding-left: 10px"> VER EL MAPA</a></p>
                    <p style="color: rgb(212, 0, 0)">Precio medio: {{$result->precio_medio}}€</p>
                    <br>
                </div>

                <div class="one-column-res">
                    @if ($result->imagen_general!=NULL)
                        @if(file_exists('storage/'.$result->imagen_general))
                            <img class="modalImg" width="300px" height="200px" src="{{asset('storage').'/'.$result->imagen_general}}">
                        @endif
                    @endif

                    @if ($result->imagen1!=NULL)
                        @if(file_exists('storage/'.$result->imagen1))
                            <img class="modalImg" width="300px" height="200px" src="{{asset('storage').'/'.$result->imagen1}}">
                        @endif
                    @endif
                    
                    @if ($result->imagen2!=NULL)
                        @if(file_exists('storage/'.$result->imagen2))
                            <img class="modalImg" width="300px" height="200px" src="{{asset('storage').'/'.$result->imagen2}}">
                        @endif
                    @endif
                    
                    @if ($result->imagen3!=NULL)
                        @if(file_exists('storage/'.$result->imagen3))
                            <img class="modalImg" width="300px" height="200px" src="{{asset('storage').'/'.$result->imagen3}}">
                        @endif
                    @endif
                    
                    @if ($result->imagen4!=NULL)
                        @if(file_exists('storage/'.$result->imagen4))
                            <img class="modalImg" width="300px" height="200px" src="{{asset('storage').'/'.$result->imagen4}}">
                        @endif
                    @endif
                </div>

                <div class="one-column-res">
                    <h2 style="border-bottom: 1.8px solid rgba(0, 0, 0, 0.459)">Descripción</h2>
                    <p style="text-align:justify">{{$result->descripcion}}</p>
                </div>

                <div class="one-column-res">
                    <h2 style="border-bottom: 1.8px solid rgba(0, 0, 0, 0.459)">Danos tu opinión</h2>
                    <form action="{{url("addValoracion")}}" onsubmit="return validarValoracion();" method="post">
                        @csrf
                        <textarea type="text" name="comentario" rows="10" style="resize: none"></textarea>
                        <br>
                        <br>
                        <label for="like"><input type="radio" id="radiolike" name="valoracion" value="1"><i id="like" class="far fa-smile" style="color: rgba(19, 160, 0, 0.322)"></i></label>                        
                        <label for="dislike"><input type="radio" id="radiodislike" name="valoracion" value="0"><i id="dislike" class="far fa-frown" style="color: rgb(245, 0, 0,0.322)"></i></label>
                        <input type="hidden" name="id" value="{{$result->id}}">
                        <br>
                        <br>
                        <br>
                        <input type="submit" value="Enviar opinión">
                    </form>
                    <script>
                        window.onload = function(){
                            let radiolike = document.getElementById("radiolike");
                            let radiodislike = document.getElementById("radiodislike");
                            let like = document.getElementById("like");
                            let dislike = document.getElementById("dislike");
                            if (radiolike.checked) {
                                like.style.color = "rgba(19, 160, 0)";
                                dislike.style.color = "rgb(245, 0, 0,0.322)";
                            }else if (radiodislike.checked){
                                like.style.color = "rgba(19, 160, 0,0.322)";
                                dislike.style.color = "rgb(245, 0, 0)";   
                            }
                            radiolike.onclick = function(){
                                like.style.color = "rgba(19, 160, 0)";
                                dislike.style.color = "rgb(245, 0, 0,0.322)";
                            }
                            radiodislike.onclick = function(){
                                like.style.color = "rgba(19, 160, 0,0.322)";
                                dislike.style.color = "rgb(245, 0, 0)";
                            }
                        }
                        function validarValoracion(){
                                let radiolike = document.getElementById("radiolike");
                                let radiodislike = document.getElementById("radiodislike");
                                if (radiolike.checked == false && radiodislike.checked == false) {
                                    alertify.error("Tienes que elegir una valoracion");
                                    return false;
                                }else{
                                    return true;
                                }
                            }
                    </script>
                </div>

                <div class="one-column-res">
                    @if ($valoraciones!=NULL)
                    <h2 style="border-bottom: 1.8px solid rgba(0, 0, 0, 0.459)">Opiniones</h2>
                    @foreach ($valoraciones as $valo)
                        <div class="valoraciones">
                            @if ($valo->valoracion==1)
                                <p><i class="far fa-smile" style="color: rgb(19, 160, 0)"></i> | {{$valo->nombre}}</p>
                                @if($valo->comentario != null || $valo->comentario != "")
                                <p><i class="far fa-comment"></i> | {{$valo->comentario}}</p>
                                @endif
                            @else
                                <p><i class="far fa-frown" style="color: rgb(245, 0, 0)"></i> | {{$valo->nombre}}</p>
                                @if($valo->comentario != null || $valo->comentario != "")
                                <p><i class="far fa-comment"></i> | {{$valo->comentario}}</p>
                                @endif
                            @endif
                        </div>
                    @endforeach
                    @endif
                    
                </div>
            @endforeach
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
                <p><img src="../../../public/img/applestore.png" alt="applestore" style="cursor: pointer"></p>
                <p><img src="../../../public/img/playstore.png" alt="googleplay" style="cursor: pointer"></p>
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
                <p><img src="../../../public/img/instagram.png" alt="instagram" width="25px"><img src="../../../public/img/facebook.png" alt="facebook" width="38px" style="padding-left: 10px;"></p>
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