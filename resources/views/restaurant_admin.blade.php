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
    <title>Document</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>Imagen general</th>
            <th>Imagen principal</th>
            <th>Imagen secundario</th>
            <th>Imagen tercera</th>
            <th>Imagen cuarta</th>
        </tr>
        @foreach ($restaurant as $result)
        <tr>
            <td><img src="{{asset('storage').'/'.$result->imagen_general}}" width="120"></td>
            <td><img src="{{asset('storage').'/'.$result->imagen1}}" width="120"></td>
            <td><img src="{{asset('storage').'/'.$result->imagen2}}" width="120"></td>
            <td><img src="{{asset('storage').'/'.$result->imagen3}}" width="120"></td>
            <td><img src="{{asset('storage').'/'.$result->imagen4}}" width="120"></td>
        </tr>
        <tr>
            <td>
                @if($result->imagen_general == null || $result->imagen_general == "")
                    <form action="{{url('addImage')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{method_field('PUT')}}
                        <input type="file" name="imagen">
                        <input type="submit" value="Añadir Imagen">
                        <input type="hidden" name="rowName" value="imagen_general">
                        <input type="hidden" name="id" value="{{$result->id}}">
                    </form>
                @else
                <form action="{{url('updImage')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{method_field('PUT')}}
                    <input type="file" name="imagen">
                    <input type="submit" value="Cambiar Imagen">
                    <input type="hidden" name="rowName" value="imagen_general">
                    <input type="hidden" name="id" value="{{$result->id}}">
                </form>
                <form action="{{url('delImage')}}" method="post">
                    @csrf
                    {{method_field('PUT')}}
                    <input type="submit" value="Eliminar Imagen">
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
                        <input type="file" name="imagen">
                        <input type="submit" value="Añadir Imagen">
                        <input type="hidden" name="rowName" value="imagen1">
                        <input type="hidden" name="id" value="{{$result->id}}">
                    </form>
                @else
                <form action="{{url('updImage')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{method_field('PUT')}}
                    <input type="file" name="imagen">
                    <input type="submit" value="Cambiar Imagen">
                    <input type="hidden" name="rowName" value="imagen1">
                    <input type="hidden" name="id" value="{{$result->id}}">
                </form>
                <form action="{{url('delImage')}}" method="post">
                    @csrf
                    {{method_field('PUT')}}
                    <input type="submit" value="Eliminar Imagen">
                    <input type="hidden" name="rowName" value="imagen1">
                    <input type="hidden" name="id" value="{{$result->id}}">
                </form>
                @endif
            </td>
            <td>
                @if($result->imagen2 == null || $result->imagen2 == "")
                    <form action="{{url('addImage')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{method_field('PUT')}}
                        <input type="file" name="imagen">
                        <input type="hidden" name="rowName" value="imagen2">
                        <input type="submit" value="Añadir Imagen">
                        <input type="hidden" name="id" value="{{$result->id}}">
                    </form>
                @else
                <form action="{{url('updImage')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{method_field('PUT')}}
                    <input type="file" name="imagen">
                    <input type="hidden" name="rowName" value="imagen2">
                    <input type="submit" value="Cambiar Imagen">
                    <input type="hidden" name="id" value="{{$result->id}}">
                </form>
                <form action="{{url('delImage')}}" method="post">
                    @csrf
                    {{method_field('PUT')}}
                    <input type="submit" value="Eliminar Imagen">
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
                        <input type="file" name="imagen">
                        <input type="hidden" name="rowName" value="imagen3">
                        <input type="submit" value="Añadir Imagen">
                        <input type="hidden" name="id" value="{{$result->id}}">
                    </form>
                @else
                <form action="{{url('updImage')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{method_field('PUT')}}
                    <input type="file" name="imagen">
                    <input type="submit" value="Cambiar Imagen">
                    <input type="hidden" name="rowName" value="imagen3">
                    <input type="hidden" name="id" value="{{$result->id}}">
                </form>
                <form action="{{url('delImage')}}" method="post">
                    @csrf
                    {{method_field('PUT')}}
                    <input type="submit" value="Eliminar Imagen">
                    <input type="hidden" name="rowName" value="imagen3">
                    <input type="hidden" name="id" value="{{$result->id}}">
                </form>
                @endif
            </td>
            <td>
                @if($result->imagen4 == null || $result->imagen4 == "")
                    <form action="{{url('addImage')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{method_field('PUT')}}
                        <input type="file" name="imagen">
                        <input type="submit" value="Añadir Imagen">
                        <input type="hidden" name="rowName" value="imagen4">
                        <input type="hidden" name="id" value="{{$result->id}}">
                    </form>
                @else
                <form action="{{url('updImage')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{method_field('PUT')}}
                    <input type="file" name="imagen">
                    <input type="submit" value="Cambiar Imagen">
                    <input type="hidden" name="rowName" value="imagen4">
                    <input type="hidden" name="id" value="{{$result->id}}">
                </form>
                <form action="{{url('delImage')}}" method="post">
                    @csrf
                    {{method_field('PUT')}}
                    <input type="submit" value="Eliminar Imagen">
                    <input type="hidden" name="rowName" value="imagen4">
                    <input type="hidden" name="id" value="{{$result->id}}">
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>