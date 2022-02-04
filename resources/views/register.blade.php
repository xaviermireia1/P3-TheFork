<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../public/css/style_register.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../public/img/icono.png">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Registro</title>
    <script src="js/validacionLogin.js"></script>
</head>
<body>
    <form action="{{url('registerPost')}}" method="post" onsubmit="return validarRegister();">
        @csrf
        <p>Nombre</p>
        <input type="text" name="nombre" id="nombre" placeholder="Introduce tu nombre...">
        <p>Apellidos</p>
        <input type="text" name="apellidos" id="apellidos" placeholder="Introduce tu contraseña...">
        <p>Email</p>
        <input type="email" name="email" id="email" placeholder="Introduce email...">
        <p>Contraseña</p>
        <input type="password" name="pass" id="pass" placeholder="Introduce contraseña...">
        <p>Verificar contraseña</p>
        <input type="password" name="pass2" id="pass2" placeholder="Verificar contraseña...">
        <input type="submit" value="Registrarme">
    </form>
</body>
</html>