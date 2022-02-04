<?php

namespace App\Http\Controllers;

use App\Models\Restaurante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
<<<<<<< HEAD
        return view('login');
=======
        return view('home');
>>>>>>> main
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //Vista de crear restaurante
    public function create()
    {
        //
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
    //login vista
    public function login(){
        return view('login');
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
