<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use View;
use DB;
use Auth;

class CategoriasController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return Response
   */
   public function registrarcategoria()
   {
     $categorias=DB::table('app_listas')->where('id_tipo_lista',4)->get();
     return View::make("categorias.registrarcategoria")->with(array('categorias'=>$categorias));
   }
   public function crear(Request $request)
   {
     $this->validate($request, [
       'nombre' => 'required',
       'descripcion'=>'required',
       'codigo'=>'required|numeric|min:10|unique:app_listas,valor_lista',
   ]);

   DB::table('app_listas')->insert([['valor_lista'=>$request->codigo,'valor_item'=>$request->nombre,'descripcion'=>$request->descripcion,'id_tipo_lista'=>4]]);

   return back();
   }
   public function editar($id)
   {
     $categorias=DB::table('app_listas')->where('id_tipo_lista',4)->where('valor_lista',$id)->get();
     return View::make("categorias.editarcategoria")->with(array('categorias'=>$categorias));
   }
   public function editarcategoria(Request $request)
   {
     $this->validate($request, [
       'nombre' => 'required',
       'descripcion'=>'required',
   ]);
   DB::table('app_listas')->where('id_tipo_lista',4)->where('valor_lista',$request->id)->update(['valor_item'=>$request->nombre,'descripcion'=>$request->descripcion]);
return redirect('categoria/'.$request->id);
//    'codigo'=>'required|numeric|min:10|unique:app_listas,valor_lista',
   }
   public function buscar()
   {
     $categorias=DB::table('app_listas')->where('id_tipo_lista',4)->get();
     return View::make("categorias.buscar")->with(array('categorias'=>$categorias));
   }
   public function categoria($id)
   {
     $categorias=DB::table('app_listas')->where('id_tipo_lista',4)->where('valor_lista',$id)->get();
     return View::make("categorias.ver")->with(array('categorias'=>$categorias));
   }



}
