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
                return redirect('login');
            }
        } catch (\Throwable $e) {
            //En caso de error impredecible obtendremos el mismo error mediante $e
            //return $e->getMessage();
            return redirect('login');
        }
    }

    //Pagina principal
    public function index()
    {
        return view("home");
    }

    public function indexAdm()
    {
        return view("home_admin");
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
    public function show(Restaurante $restaurante)
    {
        //
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

    //Funciones propias
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
    //funcion login
    public function loginPost(Request $request){

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
