<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use DB;
use Auth;
use \Milon\Barcode\DNS1D;
use File;
use Illuminate\Contracts\Filesystem\Filesystem;
use Storage;
use Carbon\Carbon;
use View;



class ProductosController extends Controller
{
  public function registrarproducto()
  {
  $categorias=DB::table('app_listas')->where('id_tipo_lista',4)->get();
  $productos=DB::table('app_productos')->select('codigo','nombre','descripcion','vl_mayorista','vl_minorista')->get();
  return View::make("productos.registerproduct")->with(array('productos'=>$productos,'categorias'=>$categorias));
  }
  public function crearproducto(Request $request)
  {
  $this->validate($request, ['nombre' => 'required|unique:app_productos,nombre',]);
  $codigo= rand(1000, 9999);
  $contador=DB::table('app_productos')->where('codigo',$codigo)->count();
  while ($contador > 0) {
    $codigo= rand(1000, 9999);
    $contador=DB::table('app_productos')->where('codigo',$codigo)->count();
  }
  $contador2=DB::table('app_productos')->where('nombre',$request->nombre)->count();
  if ($contador2>0) {
    Session::flash('flash_message', 'Ya existe un producto con este nombre');
    return back();
  }


  DB::table('app_productos')->insert([['nombre'=>strtoupper($request->nombre),'codigo'=>$codigo,
  'descripcion'=>strtoupper($request->descripcion),'vl_mayorista'=>$request->vrmayorista,'vl_minorista'=>$request->vrminorista]]);
  Session::flash('flash_message', 'se ha guardado el siguiente producto: ' .strtoupper($request->nombre));
  return back();
  }
}
