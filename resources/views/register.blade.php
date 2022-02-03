<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../public/css/style.css">
    <title>Registro</title>
    <script src="js/validar.js"></script>
</head>
<body>
    <form action="{{url('/registerPost')}}" method="post" onsubmit="validarRegister();">
        @csrf
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