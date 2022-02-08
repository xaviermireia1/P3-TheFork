<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayuda TheFork</title>
    <link rel="stylesheet" href="css/style_ayuda2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;500&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../public/img/icono.png">
</head>

<body>
    <header>
        <div class="row" id="section1">
            <div class="one-column-s1">
                <a href="{{ url('logout')}}">
                    <p><b>CERRAR SESIÓN</b></p>
                </a>
            </div>
        </div>
        <div class="row" id="section2">
            <img src="../public/img/theforklogo.jpg" alt="logo" width="10%" style="padding: 5px 0px 5px 20px">
        </div>
        <div class="row" id="section3">
            <h2 style="font-weight: 600; padding: 80px 0px 80px 40vh; font-size:28px">Estamos aquí para ayudarte.</h2>
        </div>
    </header>

    <div class="row" id="section4">
        <div class="one-column-s4">
            <div class="two-column-s4">
                <div class="box">
                    <center>
                        <div>
                            <img src="img/telefono.png" alt="icono telefono" width="15%">
                        </div>
                        <div>
                            <p>Contáctenos vía telefónica:</p>
                            <p><b>918 362 213</b></p>
                        </div>
                    </center>
                </div>
            </div>

            <div class="two-column-s4">
                <div class="box">
                <center>
                    <div>
                        <img src="img/correo.png" alt="icono telefono" width="15%">
                    </div>
                    <div>
                        <p>Contáctenos vía email:</p>
                        <p><b>atencion.cliente@thefork.com</b></p>      
                    </div>
                </center>
                </div>
            </div>
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
