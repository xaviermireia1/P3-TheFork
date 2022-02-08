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
        //Proceso de validación por parte del server, la cual en este ejemplo pondremos el campo required, y el tamaño máximo que deberá tener
       try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:150',
                'descripcion' => 'required|string|max:2000',
                'direccion' => 'required|string|max:100',
                'correo_responsable' => 'required|string|max:70',
                'correo:restaurante' => 'required|string|max:70',
                'tipo_cocina' => 'required|string|max:150',
                'imagen_general' => 'required|mimes:jpg,png,jpeg,webp,svg'
            ]);
       } catch (\Throwable $th) {
           throw $th;
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
        $restaurantes=DB::select('SELECT rest.nombre,rest.direccion,img.imagen_general
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

    // Vista de modificar restaurante posible modalbox
    public function edit(Restaurante $restaurante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Restaurante  $restaurante
     * @return \Illuminate\Http\Response
     */
    
     //Sentencia de actualizar datos
    public function update(Request $request, Restaurante $restaurante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Restaurante  $restaurante
     * @return \Illuminate\Http\Response
     */
    
     //Eliminar datos del restaurante
    public function destroy(Restaurante $restaurante)
    {
        
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

        //Funcion parair a vista restaurante cliente
        public function restaurantHome($id){
            $restaurant=DB::select("SELECT rest.nombre,rest.direccion,rest.descripcion,cook.tipo_cocina,img.*,sum(tbl_valoracion.valoracion) as likes,tbl_valoracion.comentario,price.precio_medio,usuario.nombre
            FROM tbl_restaurante rest 
            INNER JOIN tbl_tipo_cocina cook ON rest.id_tipo_cocina=cook.id
            INNER JOIN tbl_imagen img ON rest.id_imagen_fk=img.id
            LEFT JOIN tbl_valoracion ON tbl_valoracion.id_restaurante_fk=rest.id
            INNER JOIN tbl_carta price ON price.id_restaurante_fk=rest.id
            INNER JOIN tbl_usuario usuario ON tbl_valoracion.id_usuario_fk=usuario.id
            where rest.id = $id
            group by rest.nombre, img.id, img.imagen_general, img.imagen1, img.imagen2, img.imagen3, img.imagen4, rest.direccion, rest.descripcion, cook.tipo_cocina, tbl_valoracion.comentario, price.precio_medio, usuario.nombre");
            return view("restaurant",compact("restaurant"));
        }

}
