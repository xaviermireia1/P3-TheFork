<?php

namespace App\Http\Controllers;

use App\Models\Restaurante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

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
        $restaurantlist = DB::select("SELECT rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general,sum(val.valoracion) as likes
        FROM tbl_restaurante rest 
        INNER JOIN tbl_tipo_cocina cook ON rest.id_tipo_cocina=cook.id
        INNER JOIN tbl_imagen img ON rest.id_imagen_fk=img.id
        LEFT JOIN tbl_valoracion val ON val.id_restaurante_fk=rest.id
        GROUP BY rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general");
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
            'descripcion' => 'required|string|max:2000',
            'direccion' => 'required|string|max:100',
            'correo_responsable' => 'required|string|max:70|email',
            'tipo_cocina' => 'required|string|max:200',
            'precio_medio' => 'required|int',
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
            $restaurantes=DB::select('SELECT rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general,sum(val.valoracion) as likes
            FROM tbl_restaurante rest 
            INNER JOIN tbl_tipo_cocina cook ON rest.id_tipo_cocina=cook.id
            INNER JOIN tbl_imagen img ON rest.id_imagen_fk=img.id
            LEFT JOIN tbl_valoracion val ON val.id_restaurante_fk=rest.id
            WHERE rest.nombre like ? AND cook.tipo_cocina like ?
            GROUP BY rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general
            ',['%'.$request->input('nombre').'%','%'.$request->input('tipo_cocina').'%']);
        //Si selecciono likes mostramos por más likes
        }else if($request->input('likes')=="likes"){
            $restaurantes=DB::select('SELECT rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general,sum(val.valoracion) as likes
            FROM tbl_restaurante rest 
            INNER JOIN tbl_tipo_cocina cook ON rest.id_tipo_cocina=cook.id
            INNER JOIN tbl_imagen img ON rest.id_imagen_fk=img.id
            LEFT JOIN tbl_valoracion val ON val.id_restaurante_fk=rest.id
            WHERE rest.nombre like ? AND cook.tipo_cocina like ?
            GROUP BY rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general
            ORDER BY val.valoracion DESC',['%'.$request->input('nombre').'%','%'.$request->input('tipo_cocina').'%']); 
        //Si selecciono dislike mostramos por menos likes
        }else{
            $restaurantes=DB::select('SELECT rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general,sum(val.valoracion) as likes
            FROM tbl_restaurante rest 
            INNER JOIN tbl_tipo_cocina cook ON rest.id_tipo_cocina=cook.id
            INNER JOIN tbl_imagen img ON rest.id_imagen_fk=img.id
            LEFT JOIN tbl_valoracion val ON val.id_restaurante_fk=rest.id
            WHERE rest.nombre like ? AND cook.tipo_cocina like ?
            GROUP BY rest.id,rest.nombre,rest.direccion,cook.tipo_cocina,img.imagen_general
            ORDER BY val.valoracion ASC',['%'.$request->input('nombre').'%','%'.$request->input('tipo_cocina').'%']); 
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
            $restaurantContent = DB::select("SELECT rest.id,rest.nombre,rest.direccion,rest.correo_responsable,rest.descripcion,rest.correo_restaurante,cook.tipo_cocina,price.precio_medio
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
    //Registro vista
    public function register(){
        return view('register');
    }
    public function registerPost(Request $request){
        //Comprobamos si existe el email que ha introducido en la base de datos
        $existmail=DB::select('select email from tbl_usuario where email=?',[$request->input('email')]);
        //Si el resultado es menor a uno hacemos el registro
        if (count($existmail) < 1) {
            try {
                //Encriptamos la contraseña a sha1
                $password = sha1($request->input('password'));
                DB::insert('insert into tbl_usuario (nombre, apellidos,email,pass,rol) values (?,?,?,?,"cliente")',[$request->input('nombre'),$request->input('apellidos'),$request->input('email'),$password]);
                //Le metemos la variable de session con el nombre email
                $request->session()->put('email',$request->email);
                return redirect("home");
            } catch (\Throwable $th) {
                return $th;
            }
        }else{
            return redirect("register");
        }
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
        try {
            //recogemos los datos, teniendo exepciones, como el token que utiliza laravel y el método
            $datas = $request->except('_token', '_method');
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
                    return redirect("home-adm");
                }else{
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
    //Funcion para agregar foto
    public function addImage($idRes){

    }
    //Funcion para eliminar foto
    public function delImage($idImg){

    }
    //Funcion para cambiar foto
    public function changeImage($idImg){

    }
}
