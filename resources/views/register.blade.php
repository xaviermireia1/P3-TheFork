<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../public/css/style_register.css">
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;500&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../public/img/icono.png">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Registro</title>
    <script src="js/validacionLogin.js"></script>
</head>
<body>
    <header>
        <div class="row" id="section1">
            <div class="one-column-s1">
                <a href="{{ url('ayuda')}}">
                    <p><b style="padding-right: 10px;" onclick="">AYUDA</b></p>
                </a>
            </div>
            <div class="one-column-s1">
                <p><b> | </b></p>
            </div>
            <div class="one-column-s1">
                <a href="{{ url('/')}}">
                    <p><b >LOGIN</b></p>
                </a>
            </div>
        </div>
        <div class="row" id="section2">
            <img src="../public/img/theforklogo.jpg" alt="logo" width="10%" style="padding: 5px 0px 5px 20px">
        </div>
    </header>

    <div class="row" id="section3">
        <div class="two-column-s3">
            <div>
                <form action="{{url('registerPost')}}" method="post" onsubmit="return validarRegister();">
                    @csrf
                    <center>
                        <h1>Registration</h1>
                    </center>
                    <p>Nombre</p>
                    <input type="text" name="nombre" id="nombre" placeholder="Introduce tu nombre...">
                    <br>
                    <p>Apellidos</p>
                    <input type="text" name="apellidos" id="apellidos" placeholder="Introduce tus apellidos...">
                    <br>
                    <p>Email</p>
                    <input type="email" name="email" id="email" placeholder="Introduce email...">
                    <br>
                    <p>Contraseña</p>
                    <input type="password" name="pass" id="pass" placeholder="Introduce contraseña...">
                    <br>
                    <p>Verificar contraseña</p>
                    <input type="password" name="pass2" id="pass2" placeholder="Verificar contraseña...">
                    <input type="submit" value="REGISTRARME">
                </form>
            </div>
        </div>
            <div>
                <img src="img/logincomida.png" alt="comida" style="padding-top: 30px">
            </div>
        
    </div>
</body>
</html>