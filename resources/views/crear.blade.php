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
    <!--Es muy importante añadir el enctype debido a que en caso de que no esté obtendremos muchos errores-->
    <form action="{{url("crear-proc")}}" method="post" enctype="multipart/form-data">
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
                {{--Como value pasamos el id del resultado que mostramos--}}
                <option value="{{$result->id}}">{{$result->tipo_cocina}}</option>
            @endforeach 
        </select></br>
        <span>Precio medio</span>
            <input type="number" name="precio_medio"></br>
        <span>Imagen</span>
            <input type="file" name="imagen_general"></br>
        @error('imagen_general')
        <br>
        {{$message}}
        @enderror
        <input type="submit" value="Crear restaurante">
    </form>
    
</body>
</html>
