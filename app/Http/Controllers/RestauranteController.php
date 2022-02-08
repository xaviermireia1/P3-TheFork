<?php

namespace App\Http\Controllers;

use App\Models\Restaurante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\MAIL;
use App\Mail\SendMessage;

class RestauranteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //Pagina principal
    public function index()
    {
        $restaurantlist = DB::select("SELECT rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general,sum(val.valoracion) as likes,price.precio_medio
        FROM tbl_restaurante rest 
        INNER JOIN tbl_tipo_cocina cook ON rest.id_tipo_cocina=cook.id
        INNER JOIN tbl_imagen img ON rest.id_imagen_fk=img.id
        LEFT JOIN tbl_valoracion val ON val.id_restaurante_fk=rest.id
        INNER JOIN tbl_carta price ON price.id_restaurante_fk=rest.id
        GROUP BY rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general,price.precio_medio");
        //Para el filtro por seleccion de tipo cocina
        $cooktypes = DB::select("SELECT * FROM tbl_tipo_cocina");
        return view("home",compact("restaurantlist","cooktypes"));
    }

    public function indexAdm()
    {
        $restaurantlist = DB::select("SELECT rest.id,rest.nombre,rest.direccion,img.imagen_general
        FROM tbl_restaurante rest 
        INNER JOIN tbl_tipo_cocina cook ON rest.id_tipo_cocina=cook.id
        LEFT JOIN tbl_imagen img ON rest.id_imagen_fk=img.id");
        return view("home_admin",compact("restaurantlist"));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //Vista de crear restaurante
    public function create()
    {
        try {
            //Obtenemos los resultados de una tabla en concreto, para poder usar esos valores en un select
            $dbExtraction = DB::table('tbl_tipo_cocina')->get();
            return view("crear", compact("dbExtraction"));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
    //Función cuya finalidad es validar los datos e insertarlos en la DB, es el proceso de inserción
    public function crearProc(Request $request){
        $datas = $request->except('_token'); 
        //Proceso de validación por parte del server, la cual en este ejemplo pondremos el campo required, y el tamaño máximo que deberá tener.
        //Primero pasará por aquí antes de insertar los datos en la DB, simplemente los valida
        $request->validate([
            'nombre' => 'required|string|max:150',
            'direccion' => 'required|string|max:100',
            'correo_responsable' => 'required|string|max:70|email',
            'tipo_cocina' => 'required|string|max:200',
            'precio_medio' => 'required|between:0,99.99',
            //Tiene que estar el enctype en el formulario!!!!
            'imagen_general' =>'required|mimes:jpg,png,jpeg,webp,svg'
        ]); 
        //La variable foto recoje el input file del form y lo almacena en el public de uploads se necesita el enlace simbólico entre storage y public
        //Enlace simbólico php artisan storage:link -> En el terminal
        $foto = $request->file('imagen_general')->store('uploads','public');
        try {
            //inicializa la transacción, aquí indicamos que el código siguiente contendrá inserciones en base de datos, mismas que no se verán reflejadas a menos que se haga un commit
            DB::beginTransaction();
                //Insertamos dato, guardándonos el id de la inserción
                //Insertamos y recogemos el último registro insertado en la tabla, para futuramente insertarlo como fk
                $id_imagenGeneral= DB::table('tbl_imagen')->insertGetId([
                    /* 'imagen_general' => $request['imagen_general'], */
                    'imagen_general' => $foto,
                ]);
                //"precio_medio"=>$id_precioMedio
                $idRest = DB::table("tbl_restaurante")->insertGetId(["nombre"=>$request['nombre'],"descripcion"=>$request['descripcion'],"direccion"=>$request['direccion'],
                "correo_responsable"=>$request['correo_responsable'],"correo_restaurante"=>$request['correo_restaurante'],"id_tipo_cocina"=>$request['tipo_cocina'],"id_imagen_fk"=>$id_imagenGeneral]);

                DB::table('tbl_carta')->insert(['precio_medio'=> $request['precio_medio'],'id_restaurante_fk'=>$idRest]);
                
            //En caso de que todas las consultas a la BD se realicen con éxito, al leer este método se dará por entendido que todos los cambios realizados anteriormente quedaran reflejados en la base de datos
            DB::commit();
            return redirect("home-adm");
                
        } catch (\Exception $e) {
                DB::rollback();
                //En caso de error, obtendremos el mensaje
                return $e->getMessage();
        }
        //Como se usa validated en la query, como puedo insertar en una table diefente
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
     //Almacenar los datos cuando creas un restaurante
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Restaurante  $restaurante
     * @return \Illuminate\Http\Response
     */

    //Filtrar por AJAX
    public function show(Request $request)
    {
        //Si selecciono todos o no lo ha seleccionado mostramos de manera independiente
        if ($request->input('likes')=="" || $request->input('likes')==null) {
            if ($request->input('precio_medio')=="" || $request->input('precio_medio')==null) {
                //Si no pone precio se muestra tal cual
                $restaurantes=DB::select('SELECT rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general,sum(val.valoracion) as likes,price.precio_medio 
                FROM tbl_restaurante rest 
                INNER JOIN tbl_tipo_cocina cook ON rest.id_tipo_cocina=cook.id
                INNER JOIN tbl_imagen img ON rest.id_imagen_fk=img.id
                LEFT JOIN tbl_valoracion val ON val.id_restaurante_fk=rest.id
                INNER JOIN tbl_carta price ON price.id_restaurante_fk=rest.id
                WHERE rest.nombre like ? AND cook.tipo_cocina like ?
                GROUP BY rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general,val.valoracion,price.precio_medio
                ',['%'.$request->input('nombre').'%','%'.$request->input('tipo_cocina').'%']);
                //Si el precio es caro
            }elseif ($request->input('precio_medio')=="caro") {
                $restaurantes=DB::select('SELECT rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general,sum(val.valoracion) as likes,price.precio_medio 
                FROM tbl_restaurante rest 
                INNER JOIN tbl_tipo_cocina cook ON rest.id_tipo_cocina=cook.id
                INNER JOIN tbl_imagen img ON rest.id_imagen_fk=img.id
                LEFT JOIN tbl_valoracion val ON val.id_restaurante_fk=rest.id
                INNER JOIN tbl_carta price ON price.id_restaurante_fk=rest.id
                WHERE rest.nombre like ? AND cook.tipo_cocina like ?
                GROUP BY rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general,val.valoracion,price.precio_medio
                ORDER BY price.precio_medio DESC',['%'.$request->input('nombre').'%','%'.$request->input('tipo_cocina').'%']);
                //Si el precio es barato
            }else{
                $restaurantes=DB::select('SELECT rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general,sum(val.valoracion) as likes,price.precio_medio 
                FROM tbl_restaurante rest 
                INNER JOIN tbl_tipo_cocina cook ON rest.id_tipo_cocina=cook.id
                INNER JOIN tbl_imagen img ON rest.id_imagen_fk=img.id
                LEFT JOIN tbl_valoracion val ON val.id_restaurante_fk=rest.id
                INNER JOIN tbl_carta price ON price.id_restaurante_fk=rest.id
                WHERE rest.nombre like ? AND cook.tipo_cocina like ?
                GROUP BY rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general,val.valoracion,price.precio_medio
                ORDER BY price.precio_medio ASC',['%'.$request->input('nombre').'%','%'.$request->input('tipo_cocina').'%']);
            }
        //Si selecciono likes mostramos por más likes
        }else if($request->input('likes')=="likes"){
            if ($request->input('precio_medio')=="" || $request->input('precio_medio')==null) {
                //Si no pone precio se muestra tal cual
                $restaurantes=DB::select('SELECT rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general,sum(val.valoracion) as likes,price.precio_medio 
                FROM tbl_restaurante rest 
                INNER JOIN tbl_tipo_cocina cook ON rest.id_tipo_cocina=cook.id
                INNER JOIN tbl_imagen img ON rest.id_imagen_fk=img.id
                LEFT JOIN tbl_valoracion val ON val.id_restaurante_fk=rest.id
                INNER JOIN tbl_carta price ON price.id_restaurante_fk=rest.id
                WHERE rest.nombre like ? AND cook.tipo_cocina like ?
                GROUP BY rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general,val.valoracion,price.precio_medio
                ORDER BY val.valoracion DESC',['%'.$request->input('nombre').'%','%'.$request->input('tipo_cocina').'%']);
                //Si el precio es caro
            }elseif ($request->input('precio_medio')=="caro") {
                $restaurantes=DB::select('SELECT rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general,sum(val.valoracion) as likes,price.precio_medio 
                FROM tbl_restaurante rest 
                INNER JOIN tbl_tipo_cocina cook ON rest.id_tipo_cocina=cook.id
                INNER JOIN tbl_imagen img ON rest.id_imagen_fk=img.id
                LEFT JOIN tbl_valoracion val ON val.id_restaurante_fk=rest.id
                INNER JOIN tbl_carta price ON price.id_restaurante_fk=rest.id
                WHERE rest.nombre like ? AND cook.tipo_cocina like ?
                GROUP BY rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general,val.valoracion,price.precio_medio
                ORDER BY val.valoracion DESC,price.precio_medio DESC',['%'.$request->input('nombre').'%','%'.$request->input('tipo_cocina').'%']);
                //Si el precio es barato
            }else{
                $restaurantes=DB::select('SELECT rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general,sum(val.valoracion) as likes,price.precio_medio 
                FROM tbl_restaurante rest 
                INNER JOIN tbl_tipo_cocina cook ON rest.id_tipo_cocina=cook.id
                INNER JOIN tbl_imagen img ON rest.id_imagen_fk=img.id
                LEFT JOIN tbl_valoracion val ON val.id_restaurante_fk=rest.id
                INNER JOIN tbl_carta price ON price.id_restaurante_fk=rest.id
                WHERE rest.nombre like ? AND cook.tipo_cocina like ?
                GROUP BY rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general,val.valoracion,price.precio_medio
                ORDER BY val.valoracion DESC,price.precio_medio ASC',['%'.$request->input('nombre').'%','%'.$request->input('tipo_cocina').'%']);
            }
        //Si selecciono dislike mostramos por menos likes
        }else{
            if ($request->input('precio_medio')=="" || $request->input('precio_medio')==null) {
                //Si no pone precio se muestra tal cual
                $restaurantes=DB::select('SELECT rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general,sum(val.valoracion) as likes,price.precio_medio 
                FROM tbl_restaurante rest 
                INNER JOIN tbl_tipo_cocina cook ON rest.id_tipo_cocina=cook.id
                INNER JOIN tbl_imagen img ON rest.id_imagen_fk=img.id
                LEFT JOIN tbl_valoracion val ON val.id_restaurante_fk=rest.id
                INNER JOIN tbl_carta price ON price.id_restaurante_fk=rest.id
                WHERE rest.nombre like ? AND cook.tipo_cocina like ?
                GROUP BY rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general,val.valoracion,price.precio_medio
                ORDER BY val.valoracion ASC',['%'.$request->input('nombre').'%','%'.$request->input('tipo_cocina').'%']);
                //Si el precio es caro
            }elseif ($request->input('precio_medio')=="caro") {
                $restaurantes=DB::select('SELECT rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general,sum(val.valoracion) as likes,price.precio_medio 
                FROM tbl_restaurante rest 
                INNER JOIN tbl_tipo_cocina cook ON rest.id_tipo_cocina=cook.id
                INNER JOIN tbl_imagen img ON rest.id_imagen_fk=img.id
                LEFT JOIN tbl_valoracion val ON val.id_restaurante_fk=rest.id
                INNER JOIN tbl_carta price ON price.id_restaurante_fk=rest.id
                WHERE rest.nombre like ? AND cook.tipo_cocina like ?
                GROUP BY rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general,val.valoracion,price.precio_medio
                ORDER BY val.valoracion ASC,price.precio_medio DESC',['%'.$request->input('nombre').'%','%'.$request->input('tipo_cocina').'%']);
                //Si el precio es barato
            }else{
                $restaurantes=DB::select('SELECT rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general,sum(val.valoracion) as likes,price.precio_medio 
                FROM tbl_restaurante rest 
                INNER JOIN tbl_tipo_cocina cook ON rest.id_tipo_cocina=cook.id
                INNER JOIN tbl_imagen img ON rest.id_imagen_fk=img.id
                LEFT JOIN tbl_valoracion val ON val.id_restaurante_fk=rest.id
                INNER JOIN tbl_carta price ON price.id_restaurante_fk=rest.id
                WHERE rest.nombre like ? AND cook.tipo_cocina like ?
                GROUP BY rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general,val.valoracion,price.precio_medio
                ORDER BY val.valoracion ASC,price.precio_medio ASC',['%'.$request->input('nombre').'%','%'.$request->input('tipo_cocina').'%']);
            }
        }
        return response()->json($restaurantes);
    }
    public function showAdm(Request $request){
        $restaurantes=DB::select('SELECT rest.id,rest.nombre,rest.direccion,img.imagen_general
        FROM tbl_restaurante rest 
        INNER JOIN tbl_tipo_cocina cook ON rest.id_tipo_cocina=cook.id
        LEFT JOIN tbl_imagen img ON rest.id_imagen_fk=img.id
        WHERE rest.nombre like ?
        ',['%'.$request->input('nombre').'%']);
            return response()->json($restaurantes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Restaurante  $restaurante
     * @return \Illuminate\Http\Response
     */

    // Vista de modificar restaurante, recogemos el id enviado desde la ruta del fichero web
    public function edit($id)
    {
        try {
            $restaurantContent = DB::select("SELECT rest.id,rest.nombre,rest.direccion,rest.correo_responsable,rest.descripcion,rest.correo_restaurante,cook.id as id_cocina,cook.tipo_cocina,price.precio_medio
            FROM tbl_restaurante rest 
            INNER JOIN tbl_tipo_cocina cook ON rest.id_tipo_cocina=cook.id
            INNER JOIN tbl_carta price ON price.id_restaurante_fk=rest.id
            where rest.id = $id");
            $restaurant = $restaurantContent[0];
            $tipoCocina = DB::select("SELECT * FROM tbl_tipo_cocina");
            $idPrecioMed = DB::select("SELECT 'precio_medio' FROM tbl_carta where id = $id");
            $precioMed = $idPrecioMed[0];
            return view("editar",compact("restaurant","tipoCocina", "precioMed"));
        } catch (\Throwable $e) {   
            return redirect("home-adm");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Restaurante  $restaurante
     * @return \Illuminate\Http\Response
     */
    
     //Sentencia de actualizar datos
    public function update(Request $request)
    {
        //Quitamos el token y el método
        $datas = $request->except('_token', '_method');
        //Verificamos los datos a actualizar
        $request->validate([
            'nombre' => 'required|string|max:150',
            'direccion' => 'required|string|max:100',
            'correo_responsable' => 'required|string|max:70|email',
            'tipo_cocina' => 'required|string|max:200',
            'precio_medio' => 'required|between:0,99.99',
        ]);
        try {
            DB::beginTransaction();
            //Query de actualización de datos en tbl_restaurante
                DB::update('update tbl_restaurante set nombre=?, descripcion=?, direccion=?, correo_responsable=?, correo_restaurante=?, 
                id_tipo_cocina=? where id=?',
                [$request->input('nombre'),$request->input('descripcion'),$request->input('direccion'),$request->input('correo_responsable'), $request->input('correo_restaurante'), 
                $request->input('tipo_cocina'), $request->input('id')]);
            //Query de actualización de datos en tbl_carta
            DB::update('update tbl_carta set precio_medio=? where id_restaurante_fk = ?', [$request->input('precio_medio'), $request->input('id')]);
            DB::commit();
            //Enviar correo al propietario
            $sub = "Modificación del restaurante: ".$request->input('nombre');
            $msj = "Buenas tardes,\r\n Su restaurante: ".$request->input('nombre')." Se ha modificado por nuestro administrador con el correo: ".session('email')."       
            Los datos modificados se la siguiente manera: \r\n
            Nombre:".$request->input('nombre')."\r\n
            Direccion: ".$request->input('direccion')."\r\n
            Descripcion: ".$request->input('direccion')."\r\n
            Precio medio de la carta: ".$request->input('precio_medio')."
            \r\nCualquier inconveniente no dude en contactarnos. \r\n Atentamente el equipo de TheFork";
            $datos = array('message'=>$msj);
            $enviar = new SendMessage($datos);
            $enviar->sub = $sub;
            Mail::to($request->input('correo_responsable'))->send($enviar);
            //redirección a index
            return redirect('home-adm');
        } catch (\Throwable $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Restaurante  $restaurante
     * @return \Illuminate\Http\Response
     */
    
     //Eliminar datos del restaurante, id de restaurante
    public function destroy($id)
    {
        //Cogemos el id de la imagen mediante tabla de restaurante
        $idIMG=DB::table('tbl_restaurante')->select('id_imagen_fk')->where('id','=',$id)->first();
        //Cogemos todos los registros de la tabla imagen 
        $fotos = DB::table('tbl_imagen')->select('*')->where('id','=',$idIMG->id_imagen_fk)->first();
        //Cogemos todos los registros de la tabla valaración
        $valoracion=DB::table('tbl_valoracion')->select('*')->where('id_restaurante_fk','=',$id);        
        try {
            DB::beginTransaction();
                //Primer paso, eliminamos carta que contiene el id del restaurante
                DB::table('tbl_carta')->where('id_restaurante_fk','=',$id)->delete();
                //Comprobamos que las imágenes no sean nulas, si no lo son eliminamos las imagenes del srv(storage/uploads)
                if ($fotos->imagen_general != null) {
                    Storage::delete('public/'.$fotos->imagen_general); 
                }
                //Segundo paso, eliminamos carta 
                if ($fotos->imagen1 != null) {
                    Storage::delete('public/'.$fotos->imagen1); 
                }
                if ($fotos->imagen2 != null) {
                    Storage::delete('public/'.$fotos->imagen2); 
                }
                if ($fotos->imagen3 != null) {
                    Storage::delete('public/'.$fotos->imagen3); 
                }
                if ($fotos->imagen4 != null) {
                    Storage::delete('public/'.$fotos->imagen4); 
                }
                //Si existe alguna valoración del restaurante, eliminamos todos los registros que contenian restaurante
                if ($valoracion != null) {
                    DB::table('tbl_valoracion')->where('id_restaurante_fk','=',$id)->delete();
                }
                DB::table('tbl_restaurante')->where('id','=',$id)->delete();
                DB::table('tbl_imagen')->where('id','=',$fotos->id)->delete();
            DB::commit();
            return redirect('home-adm');
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        //return $coche;
        return redirect('mostrar');
    }

    //Funciones propias -----------------------------

    //Ayuda vista
    public function ayuda(){
        return view('ayuda');
    }

    public function ayuda2(){
        return view('ayuda2');
    }
    //Registro vista
    public function register(){
        return view('register');
    }
    public function registerPost(Request $request){

        $request-> validate([
            'nombre' => 'required|string|max:50',
            'apellidos' => 'required|string|max:70',
            //Esta línea comprueba que el email a validar es único, y que no existe ya en la DB
            'email' => 'required|unique:tbl_usuario,email|string|max:60',
            'pass' => 'required|string|max:255',
            'nombre' => 'required|string|max:255'
        ]);

        //Comprobamos si existe el email que ha introducido en la base de datos
        //$existmail=DB::select('select email from tbl_usuario where email=?',[$request->input('email')]);
        //Si el resultado es menor a uno hacemos el registro
        /* if (count($existmail) < 1) { */
            try {
                //Encriptamos la contraseña a sha1
                $password = sha1($request->input('password'));
                DB::insert('insert into tbl_usuario (nombre, apellidos,email,pass,rol) values (?,?,?,?,"cliente")',[$request->input('nombre'),$request->input('apellidos'),$request->input('email'),$password]);
                //Le metemos la variable de session con el nombre email
                $request->session()->put('email',$request->email);
                return redirect("home");
            } catch (\Throwable $th) {
                return redirect("register");
            }
        /* }else{
            return redirect("register");
        } */
    }
    //Función con redirección a la vista de Login
    public function login(){
        try {
            return view("login");
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    //Proceso de verificación de usuarios + redirección a la ruta correspondiente
    public function loginProc(Request $request){
        //recogemos los datos, teniendo exepciones, como el token que utiliza laravel y el método
        $datas = $request->except('_token', '_method');
        //Validación datos por parte del server, es necesario aunque pase por JS 
        $request->validate([
            'email' => 'required|string|max:60',
            'pass' => 'required|string|max:255'
        ]);

        try {
            //Hacemos la consulta con la DB, la cual contará nuestros resultados 1-0
            $queryId = DB::table('tbl_usuario')->where('email', '=', $datas['email'])->where('pass', '=', sha1($datas['pass']))->count();
            //Obtenemos todos los resultados de la DB, posteiriormente cogeremos un campo en concreto, obtenemos el primer resultado
            $userId = DB::table('tbl_usuario')->where('email', '=', $datas['email'])->where('pass', '=', sha1($datas['pass']))->first();
            //De los datos obtenidos consultamos el campo en concreto
            $rolUser = $userId->rol;
            //En caso de que la query $queryId devuelva como resultado 1(Coincidenci de datos haz...)
            if ($queryId == 1){
                //Establecemos sesión, solcitando el dato a Request
                $request->session()->put('email', $request->email);
                if($rolUser == 'Admin'){
                    $request->session()->put('rol', $rolUser);
                    return redirect("home-adm");
                }else{
                    $request->session()->put('rol', $rolUser);
                    return redirect("home");
                }
                /* return redirect('home'); */
            }else{
                //No establecemos sesión y lo devolvemos a login
                return redirect('/');
            }
        } catch (\Throwable $e) {
            //En caso de error impredecible obtendremos el mismo error mediante $e
            //return $e->getMessage();
            return redirect('/');
        }
    }
    //logout
    public function logout(Request $request){
        //Eliminar todas las variables de sesion
        $request->session()->flush();
        return redirect('/');
    }

    //Vista restaurante admin
    public function restaurantADM($id){
        $restaurant=DB::select("SELECT rest.id as idrest,rest.nombre,rest.direccion,rest.descripcion,img.*
        FROM tbl_restaurante rest 
        INNER JOIN tbl_imagen img ON rest.id_imagen_fk=img.id
        where rest.id = $id");
        return view("restaurant_admin",compact("restaurant"));
    }
    //Funcion para agregar foto
    public function addImage(Request $request){
        $request->validate([
            'imagen' =>'required|mimes:jpg,png,jpeg,webp,svg'
        ]); 
        if ($request->input('rowName')=="imagen_general") {
            $datos['imagen_general'] = $request->file('imagen')->store('uploads','public');
            DB::update("UPDATE tbl_imagen SET imagen_general=? WHERE id=?",[$datos['imagen_general'],$request->input('id')]);
        }elseif ($request->input('rowName')=="imagen1") {
            $datos['imagen1'] = $request->file('imagen')->store('uploads','public');
            DB::update("UPDATE tbl_imagen SET imagen1=? WHERE id=?",[$datos['imagen1'],$request->input('id')]);

        }elseif ($request->input('rowName')=="imagen2") {
            $datos['imagen2'] = $request->file('imagen')->store('uploads','public');
            DB::update("UPDATE tbl_imagen SET imagen2=? WHERE id=?",[$datos['imagen2'],$request->input('id')]);

        }elseif ($request->input('rowName')=="imagen3") {
            $datos['imagen3'] = $request->file('imagen')->store('uploads','public');
            DB::update("UPDATE tbl_imagen SET imagen3=? WHERE id=?",[$datos['imagen3'],$request->input('id')]);

        }elseif ($request->input('rowName')=="imagen4") {
            $datos['imagen4'] = $request->file('imagen')->store('uploads','public');
            DB::update("UPDATE tbl_imagen SET imagen4=? WHERE id=?",[$datos['imagen4'],$request->input('id')]);
        }
        return redirect('home_admin/restaurant_admin/'.$request->input('id'));
        //return $request;
    }
    //Funcion para eliminar foto
    public function delImage(Request $request){
        if ($request->input('rowName')=="imagen_general") {
            $ruta = 'storage/'.$request->input('file');
            if (file_exists($ruta) == true){
                Storage::delete('public/'.$request->input('file')); 
            }
            DB::update("UPDATE tbl_imagen SET imagen_general=? WHERE id=?",[null,$request->input('id')]); 

        }elseif ($request->input('rowName')=="imagen1") {
            $ruta = 'storage/'.$request->input('file');
            if (file_exists($ruta) == true){
                Storage::delete('public/'.$request->input('file')); 
            }
            DB::update("UPDATE tbl_imagen SET imagen1=? WHERE id=?",[null,$request->input('id')]); 
        }elseif ($request->input('rowName')=="imagen2") {
            $ruta = 'storage/'.$request->input('file');
            if (file_exists($ruta) == true){
                Storage::delete('public/'.$request->input('file')); 
            }
            DB::update("UPDATE tbl_imagen SET imagen2=? WHERE id=?",[null,$request->input('id')]); 
        }elseif ($request->input('rowName')=="imagen3") {
            $ruta = 'storage/'.$request->input('file');
            if (file_exists($ruta) == true){
                Storage::delete('public/'.$request->input('file')); 
            }
            DB::update("UPDATE tbl_imagen SET imagen3=? WHERE id=?",[null,$request->input('id')]); 

        }elseif ($request->input('rowName')=="imagen4") {
            $ruta = asset('storage/'.$request->input('file'));
            if (file_exists($ruta) == true){
                Storage::delete('public/'.$request->input('file')); 
            }
            DB::update("UPDATE tbl_imagen SET imagen4=? WHERE id=?",[null,$request->input('id')]); 
        }
        return redirect('home_admin/restaurant_admin/'.$request->input('id'));
    }
    //Funcion para cambiar foto
    public function changeImage(Request $request){
        $request->validate([
            'imagen' =>'required|mimes:jpg,png,jpeg,webp,svg'
        ]); 
        if ($request->input('rowName')=="imagen_general") {
            $ruta = 'storage/'.$request->input('file');
            if (file_exists($ruta) == true){
                Storage::delete('public/'.$request->input('file')); 
            }
            $datos['imagen_general'] = $request->file('imagen')->store('uploads','public');
            DB::update("UPDATE tbl_imagen SET imagen_general=? WHERE id=?",[$datos['imagen_general'],$request->input('id')]); 
        }elseif ($request->input('rowName')=="imagen1") {
            $ruta = 'storage/'.$request->input('file');
            if (file_exists($ruta) == true){
                Storage::delete('public/'.$request->input('file')); 
            }
            $datos['imagen1'] = $request->file('imagen')->store('uploads','public');
            DB::update("UPDATE tbl_imagen SET imagen1=? WHERE id=?",[$datos['imagen1'],$request->input('id')]); 
        }elseif ($request->input('rowName')=="imagen2") {
            $ruta = 'storage/'.$request->input('file');
            if (file_exists($ruta) == true){
                Storage::delete('public/'.$request->input('file')); 
            }
            $datos['imagen2'] = $request->file('imagen')->store('uploads','public');
            DB::update("UPDATE tbl_imagen SET imagen2=? WHERE id=?",[$datos['imagen2'],$request->input('id')]); 
        }elseif ($request->input('rowName')=="imagen3") {
            $ruta = 'storage/'.$request->input('file');
            if (file_exists($ruta) == true){
                Storage::delete('public/'.$request->input('file')); 
            }
            $datos['imagen3'] = $request->file('imagen')->store('uploads','public');
            DB::update("UPDATE tbl_imagen SET imagen3=? WHERE id=?",[$datos['imagen3'],$request->input('id')]); 

        }elseif ($request->input('rowName')=="imagen4") {
            $ruta = asset('storage/'.$request->input('file'));
            if (file_exists($ruta) == true){
                Storage::delete('public/'.$request->input('file')); 
            }
            $datos['imagen4'] = $request->file('imagen')->store('uploads','public');
            DB::update("UPDATE tbl_imagen SET imagen4=? WHERE id=?",[$datos['imagen4'],$request->input('id')]); 
        }
        return redirect('home_admin/restaurant_admin/'.$request->input('id'));
    }

        //Funcion parair a vista restaurante cliente
        public function restaurantHome($id){
            $restaurant=DB::select("SELECT rest.nombre,rest.direccion,rest.descripcion,cook.tipo_cocina,img.*,sum(tbl_valoracion.valoracion) as likes,price.precio_medio
            FROM tbl_restaurante rest 
            INNER JOIN tbl_tipo_cocina cook ON rest.id_tipo_cocina=cook.id
            INNER JOIN tbl_imagen img ON rest.id_imagen_fk=img.id
            LEFT JOIN tbl_valoracion ON tbl_valoracion.id_restaurante_fk=rest.id
            INNER JOIN tbl_carta price ON price.id_restaurante_fk=rest.id
            INNER JOIN tbl_usuario usuario ON tbl_valoracion.id_usuario_fk=usuario.id
            where rest.id = $id
            group by rest.nombre, img.id, img.imagen_general, img.imagen1, img.imagen2, img.imagen3, img.imagen4, rest.direccion, rest.descripcion, cook.tipo_cocina,price.precio_medio");
            
            $valoraciones=DB::select("SELECT tbl_valoracion.valoracion,tbl_valoracion.comentario,tbl_usuario.nombre
            FROM tbl_valoracion 
            INNER JOIN tbl_usuario ON tbl_valoracion.id_usuario_fk=tbl_usuario.id
            where id_restaurante_fk = $id");
            //return $valoraciones;
            return view("restaurant",compact("restaurant","valoraciones"));
        }
}