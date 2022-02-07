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
    <title>Crear</title>
</head>
<body>
<center>
    <h1>Nuevo restaurante</h1>
</center>
    <form action="{{url("crear-proc")}}" method="post">
        {{--Token de seguridad--}}
        @csrf
        <span>Nombre:</span>
            <input type="text" name="nombre"></br>
        <span>Descripción:</span>
            <input type="text" name="descripcion"></br>
        <span>Dirección:</span>
            <input type="text" name="direccion"></br>
        <span>Email del responsable:</span>
            <input type="email" name="correo_responsable"></br>
        <span>Email restaurante:</span>
            <input type="email" name="correo_restaurante"></br>
        <label for="cars">Tipo de cocina:</label>
        <select name="tipo_cocina" id="cars">
            <option value=""></option>
            <!--Extracción valores desde la DB, la variable se envía desde el método-->
            @foreach ($dbExtraction as $result)
                {{--Recordemos pasarle el resultado que queremos de la variable enviada desde el método--}}
                <option value="{{$result->tipo_cocina}}">{{$result->tipo_cocina}}</option>
            @endforeach 
        </select></br>
        <input type="file" name="imagen_general"></br>
        <input type="submit" value="Crear restaurante">
    </form>
    
</body>
</html>
