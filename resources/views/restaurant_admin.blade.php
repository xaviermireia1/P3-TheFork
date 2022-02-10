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
    <link rel="stylesheet" href="../../css/style_restaurant_admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
                <a href="{{ url('home-adm')}}">
                    <p style="cursor: pointer">Back</p>
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
    
    @error('imagen')
        <script>
            window.onload = function(){
                alertify.error("En las acciones insertar/modificar la imagen es obligatoria");
            }
        </script>
    @enderror
    <br>
    <br>
    <table>
        <tr>
            <th>Imagen principal</th>
            <th>Imagen 1</th>
            <th>Imagen 2</th>
            <th>Imagen 3</th>
            <th>Imagen 4</th>
        </tr>

        @foreach ($restaurant as $result)
        <tr>
            <td><img src="{{asset('storage').'/'.$result->imagen_general}}" width="300px" height="250px" class="modalImg" style="padding-left: 30px"></td>
            <td><img src="{{asset('storage').'/'.$result->imagen1}}" width="300px" height="250px" class="modalImg" style="padding-left: 30px"></td>
            <td><img src="{{asset('storage').'/'.$result->imagen2}}" width="300px" height="250px" class="modalImg" style="padding-left: 30px"></td>
            <td><img src="{{asset('storage').'/'.$result->imagen3}}" width="300px" height="250px" class="modalImg" style="padding-left: 30px"></td>
            <td><img src="{{asset('storage').'/'.$result->imagen4}}" width="300px" height="250px" class="modalImg" style="padding-left: 30px"></td>
        </tr>
        <tr>
            <td>
                @if($result->imagen_general == null || $result->imagen_general == "")
                    <form action="{{url('addImage')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{method_field('PUT')}}
                        <input type="file" name="imagen" class="foto" >
                        <input type="submit" value="Añadir Imagen" class="añadir">
                        <input type="hidden" name="rowName" value="imagen_general">
                        <input type="hidden" name="id" value="{{$result->id}}">
                    </form>
                @else
                <form action="{{url('updImage')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{method_field('PUT')}}
                    <input type="file" name="imagen" class="foto">
                    <input type="submit" value="Cambiar Imagen" class="change">
                    <input type="hidden" name="rowName" value="imagen_general">
                    <input type="hidden" name="file" value="{{$result->imagen_general}}">
                    <input type="hidden" name="id" value="{{$result->id}}">
                </form>
                <form action="{{url('delImage')}}" method="post">
                    @csrf
                    {{method_field('PUT')}}
                    <input type="submit" value="Eliminar Imagen" class="eliminar">
                    <input type="hidden" name="file" value="{{$result->imagen_general}}">
                    <input type="hidden" name="rowName" value="imagen_general">
                    <input type="hidden" name="id" value="{{$result->id}}">
                </form>
                @endif
            </td>
            <td>
                @if($result->imagen1 == null || $result->imagen1 == "")
                    <form action="{{url('addImage')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{method_field('PUT')}}
                        <input type="file" name="imagen" class="foto" >
                        <input type="submit" value="Añadir Imagen" class="añadir">
                        <input type="hidden" name="rowName" value="imagen1">
                        <input type="hidden" name="id" value="{{$result->id}}">
                    </form>
                @else
                <form action="{{url('updImage')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{method_field('PUT')}}
                    <input type="file" name="imagen" class="foto">
                    <input type="hidden" name="rowName" value="imagen1">
                    <input type="submit" value="Cambiar Imagen" class="change">
                    <input type="hidden" name="file" value="{{$result->imagen1}}">
                    <input type="hidden" name="id" value="{{$result->id}}">
                </form>
                <form action="{{url('delImage')}}" method="post">
                    @csrf
                    {{method_field('PUT')}}
                    <input type="submit" value="Eliminar Imagen" class="eliminar">
                    <input type="hidden" name="rowName" value="imagen1">
                    <input type="hidden" name="file" value="{{$result->imagen1}}">
                    <input type="hidden" name="id" value="{{$result->id}}">
                </form>
                @endif
            </td>
            <td>
                @if($result->imagen2 == null || $result->imagen2 == "")
                    <form action="{{url('addImage')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{method_field('PUT')}}
                        <input type="file" name="imagen" class="foto" >
                        <input type="hidden" name="rowName" value="imagen2">
                        <input type="submit" value="Añadir Imagen" class="añadir">
                        <input type="hidden" name="id" value="{{$result->id}}">
                    </form>
                @else
                <form action="{{url('updImage')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{method_field('PUT')}}
                    <input type="file" name="imagen" class="foto">
                    <input type="hidden" name="rowName" value="imagen2">
                    <input type="submit" value="Cambiar Imagen" class="change">
                    <input type="hidden" name="file" value="{{$result->imagen2}}">
                    <input type="hidden" name="id" value="{{$result->id}}">
                </form>
                <form action="{{url('delImage')}}" method="post">
                    @csrf
                    {{method_field('PUT')}}
                    <input type="submit" value="Eliminar Imagen" class="eliminar">
                    <input type="hidden" name="file" value="{{$result->imagen2}}">
                    <input type="hidden" name="rowName" value="imagen2">
                    <input type="hidden" name="id" value="{{$result->id}}">
                </form>
                @endif
            </td>
            <td>
                @if($result->imagen3 == null || $result->imagen3 == "")
                    <form action="{{url('addImage')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{method_field('PUT')}}
                        <input type="file" name="imagen" class="foto" >
                        <input type="hidden" name="rowName" value="imagen3">
                        <input type="submit" value="Añadir Imagen" class="añadir">
                        <input type="hidden" name="id" value="{{$result->id}}">
                    </form>
                @else
                <form action="{{url('updImage')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{method_field('PUT')}}
                    <input type="file" name="imagen" class="foto">
                    <input type="submit" value="Cambiar Imagen" class="change">
                    <input type="hidden" name="rowName" value="imagen3">
                    <input type="hidden" name="file" value="{{$result->imagen3}}">
                    <input type="hidden" name="id" value="{{$result->id}}">
                </form>
                <form action="{{url('delImage')}}" method="post">
                    @csrf
                    {{method_field('PUT')}}
                    <input type="submit" value="Eliminar Imagen" class="eliminar">
                    <input type="hidden" name="rowName" value="imagen3">
                    <input type="hidden" name="file" value="{{$result->imagen3}}">
                    <input type="hidden" name="id" value="{{$result->id}}">
                </form>
                @endif
            </td>
            <td>
                @if($result->imagen4 == null || $result->imagen4 == "")
                    <form action="{{url('addImage')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{method_field('PUT')}}
                        <input type="file" name="imagen" class="foto" >
                        <input type="submit" value="Añadir Imagen" class="añadir">
                        <input type="hidden" name="rowName" value="imagen4">
                        <input type="hidden" name="id" value="{{$result->id}}">
                    </form>
                @else
                <form action="{{url('updImage')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{method_field('PUT')}}
                    <input type="file" name="imagen" class="foto">
                    <input type="submit" value="Cambiar Imagen" class="change">
                    <input type="hidden" name="rowName" value="imagen4">
                    <input type="hidden" name="file" value="{{$result->imagen4}}">
                    <input type="hidden" name="id" value="{{$result->id}}">
                </form>
                <form action="{{url('delImage')}}" method="post">
                    @csrf
                    {{method_field('PUT')}}
                    <input type="submit" value="Eliminar Imagen" class="eliminar">
                    <input type="hidden" name="rowName" value="imagen4">
                    <input type="hidden" name="file" value="{{$result->imagen4}}">
                    <input type="hidden" name="id" value="{{$result->id}}">
                </form>
                @endif
            </td>
        </tr>
        @endforeach
       
    </table>
    <br>
    <br>
    <br>
    
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