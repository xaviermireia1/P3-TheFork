<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style_login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;500&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../public/img/icono.png">
    <title>Login</title>
    <script src="js/validar.js"></script>
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
                <a href="{{ url('register')}}">
                    <p><b >REGISTRARME</b></p>
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
                <form action="{{url('/login-proc')}}" method="post" onsubmit="validarLogin();">
                    @csrf
                    <center>
                        <h1>Log-In</h1>
                    </center>
                    <p>Email</p>
                    <input type="email" name="email" id="email" placeholder="Introduce email...">
                    <br>
                    <p>Contraseña</p>
                    <input type="password" name="pass" id="pass" placeholder="Introduce contraseña...">
                    <input type="submit" value="ENTRAR">
                </form>
            </div>
        </div>
            <div>
                <img src="img/logincomida.png" alt="comida" style="padding-top: 30px">
            </div>
        
    </div>
</body>
</html>