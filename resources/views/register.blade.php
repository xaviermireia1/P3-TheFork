<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../public/css/style.css">
    <title>Registro</title>
    <script src="js/validar.js"></script>
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
</head>
<body>
    <form action="{{url('/registerPost')}}" method="post" onsubmit="validarRegister();">
        <p>Email</p>
        <input type="email" name="email" id="email" placeholder="Introduce email...">
        <p>Contraseña</p>
        <input type="password" name="pass" id="pass">
        <p>Verificar contraseña</p>
        <input type="password" name="pass2" id="pass2">
    </form>
</body>
</html>