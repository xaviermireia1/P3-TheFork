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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/style_editar.css">
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <title>Editar TheFork</title>
    <link rel="shortcut icon" href="../../../public/img/icono.png">
</head>

<body>
    @if($errors->any())
        <script>
            window.onload = function(){
                alertify.error("Rellene los campos correctamente");
            }
        </script>
    @endif
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

    <div class="row" id="section3">
        <div class="two-column-s3">
            <div>
                <form action="{{url('home-adm/update-proc')}}" method="post" enctype="multipart/form-data">
                    {{--Token de seguridad--}}
                    @csrf
                    {{method_field('PUT')}}
                    <center>
                        <h1>Editar restaurante</h1>
                    </center>  
                    <span>Nombre:</span>
                        <input type="text" name="nombre" value="{{$restaurant->nombre}}">
                        <br>
                    <span>Descripción:</span>
                        <textarea name="descripcion" cols="30" rows="10" style="resize: none">{{$restaurant->descripcion}}</textarea>
                        <br>
                    <span>Dirección:</span>
                        <input type="text" name="direccion" value="{{$restaurant->direccion}}">
                        <br>
                    <span>Email del responsable:</span>
                        <input type="email" name="correo_responsable" value="{{$restaurant->correo_responsable}}">
                        <br>
                    <span>Email restaurante:</span>
                        <input type="email" name="correo_restaurante" value="{{$restaurant->correo_restaurante}}">
                        <br>
                    <label for="tipo_cocina">Tipo de cocina:</label>
                    <select name="tipo_cocina" id="tipo_cocina">
                        <option value="{{$restaurant->id_cocina}}">{{$restaurant->tipo_cocina}}</option>
                        <!--Extracción valores desde la DB, la variable se envía desde el método-->
                        @foreach ($tipoCocina as $result)
                            {{--Recordemos pasarle el resultado que queremos de la variable enviada desde el método--}}
                            {{--Como value pasamos el id del resultado que mostramos--}}
                            @if($result->tipo_cocina != $restaurant->tipo_cocina)
                                <option value="{{$result->id}}">{{$result->tipo_cocina}}</option>
                            @endif
                        @endforeach 
                    </select></br>
                    <span>Precio medio</span>
                        <input type="number" step="any" name="precio_medio" value="{{$restaurant->precio_medio}}">
                        <br>
                    <input type="hidden" name="id" value="{{$restaurant->id}}">
                    <input type="submit" value="Actualizar restaurante">
                </form>
            </div>
        </div>
        <div>
            <img src="../../img/eltenedor2.jpg" alt="comida2" style="padding-top: 110px; width:45%">
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