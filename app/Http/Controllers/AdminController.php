<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use View;
use DB;
use Auth;
use Session;

class AdminController extends Controller
{
    public function usuarios()
    {
    $usuarios=DB::table('users')->get();
    return View::make("admin.usuarios")->with(array('usuarios'=>$usuarios));
    }
    public function registrarusuario()
    {
      $perfiles=DB::table('app_listas')->where('id_tipo_lista',2)->get();
      $bodegas=DB::table('app_bodegas')->get();
      return View::make("auth.register")->with(array('perfiles'=>$perfiles,'bodegas'=>$bodegas));
    }
    public function registrarusuariof(Request $request)
    {

      if ($request->id_perfil==1) {
        $this->validate($request, ['name' => 'required|max:255',  'email' => 'required|email|max:255|unique:users',
      'password' => 'required|confirmed|min:6','id_perfil' => 'required',]);
      DB::table('users')->insert([
      ['name'=>$request->name,'password'=> bcrypt($request['password']),'id_perfil'=>$request['id_perfil'],'telefono'=>$request['telefono'],
       'email'=> $request['email'],'bodega_id'=>0 ]
     ]);

      $usuarios=DB::table('users')->get();
        Session::flash('flash_message', 'Usuario creado existoasmente.');
      return View::make("admin.usuarios")->with(array('usuarios'=>$usuarios));

      }elseif ($request->id_perfil==2) {
        $this->validate($request, ['name' => 'required|max:255',  'email' => 'required|email|max:255|unique:users',
      'password' => 'required|confirmed|min:6','id_perfil' => 'required',]);
      if ($request->bodega==0) {
        Session::flash('error_message', 'Debes seleccionar una bodega');
        return back();
      }
      DB::table('users')->insert([
      ['name'=>$request->name,'password'=> bcrypt($request['password']),'id_perfil'=>$request['id_perfil'],'telefono'=>$request['telefono'],
       'email'=> $request['email'],'bodega_id'=>$request->bodega ]
     ]);
     $usuarios=DB::table('users')->get();
       Session::flash('flash_message', 'Usuario creado existoasmente.');
     return View::make("admin.usuarios")->with(array('usuarios'=>$usuarios));
      }

    }

}
