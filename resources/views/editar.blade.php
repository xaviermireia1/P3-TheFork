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
    <title>Document</title>
</head>
<body>
    <form action="{{url('home-adm/update-proc')}}" method="post" enctype="multipart/form-data">
        {{--Token de seguridad--}}
        @csrf
        {{method_field('PUT')}}
        <span>Nombre:</span>
            <input type="text" name="nombre" value="{{$restaurant->nombre}}"></br>
        <span>Descripción:</span>
            <input type="text" name="descripcion" value="{{$restaurant->descripcion}}"></br>
        <span>Dirección:</span>
            <input type="text" name="direccion" value="{{$restaurant->direccion}}"></br>
        <span>Email del responsable:</span>
            <input type="email" name="correo_responsable" value="{{$restaurant->correo_responsable}}"></br>
        <span>Email restaurante:</span>
            <input type="email" name="correo_restaurante" value="{{$restaurant->correo_restaurante}}"></br>
        <label for="tipo_cocina">Tipo de cocina:</label>
        <select name="tipo_cocina" id="tipo_cocina">
            <option value="{{$restaurant->id}}">{{$restaurant->tipo_cocina}}</option>
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
            <input type="number" name="precio_medio" value="{{$restaurant->precio_medio}}"></br>
        <input type="hidden" name="id" value="{{$restaurant->id}}">
        <input type="submit" value="Actualizar restaurante">
    </form>
</body>
</html>