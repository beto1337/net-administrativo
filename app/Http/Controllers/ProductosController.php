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
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth');
  }


  public function codigodisponible($categoria)//se obtiene el valor del codigo, y se manda a la vista de registrar
  {
    $productos=DB::table('app_productos')->where('categoria',$categoria)->count();
    $producto=$productos+1;
    $count=strlen($producto);
    if ($count==1) {
      $producto="0".$producto;
    }
    $codigodisponible=DB::table('app_productos')->where('codigo',$categoria.$producto)->count();
    while ($codigodisponible>0) {
      $producto=$producto+1;
      $count=strlen($producto);
      if ($count==1) {
        $producto="0".$producto;
      }
      $codigodisponible=DB::table('app_productos')->where('codigo',$categoria.$producto)->count();
    }
    return $categoria.$producto;
  }
  public function registrarproducto()
  {
  $categorias=DB::table('app_listas')->where('id_tipo_lista',4)->select('valor_lista','valor_item')->get();
  $productos=DB::table('app_productos')->select('codigo','nombre','descripcion','vl_mayorista','vl_minorista')->get();
  return View::make("productos.registrarproducto")->with(array('productos'=>$productos,'categorias'=>$categorias));
  }
  public function crearproducto(Request $request)
  {
    if ($request->has('editarcodigo')) {
        $this->validate($request, [
          'nombre' => 'required|unique:app_productos,nombre',
          'codigo' => 'required|unique:app_productos,codigo',
          'categoria' =>'required'
      ]);
      $codigo=$request->codigo;
    }else {
        $this->validate($request, [
          'nombre' => 'required|unique:app_productos,nombre',
          'Codigo' => 'required|unique:app_productos,codigo',
          'categoria' =>'required'
      ]);
      $codigo=$request->Codigo;
    }

    if ($request->hasfile('imagenes')) {
      $files=$request->imagenes;
      foreach ($files as $file) {
        $public = \Storage::disk('public');
        $imageFileName = mt_rand(1,2147) . '.' . $file->getClientOriginalExtension();
        $filePath = $imageFileName;
         $public->put('/'.$filePath, file_get_contents($file), 'public');
        $link_[]=$imageFileName;
      }
    }else {
      $link_[]="";
    }
    $linki=implode(",",$link_);


  DB::table('app_productos')->insert([['nombre'=>strtoupper($request->nombre),'codigo'=>$codigo,
  'descripcion'=>strtoupper($request->descripcion),'vl_mayorista'=>$request->vrmayorista,'vl_minorista'=>$request->vrminorista,
  'imagen'=>$linki]]);

  Session::flash('flash_message', 'se ha guardado el siguiente producto: ' .strtoupper($request->nombre));
  return redirect('producto/'.$codigo);
  }
  public function productos()
  {
      $productos=DB::table('app_productos')->select('codigo','nombre','descripcion','vl_mayorista','vl_minorista','categoria')->get();
    return View::make("productos.buscarproducto")->with(array('productos'=>$productos));
  }

  public function editarvista()
  {
    $productos=DB::table('app_productos')->select('codigo','nombre','descripcion','vl_mayorista','vl_minorista','categoria')->get();
    return View::make("productos.editar")->with(array('productos'=>$productos));
  }

  public function productoid($codigo)
  {
    $productos=DB::table('app_productos')->where('codigo',$codigo)->take(1)->get();
    return View::make("productos.producto")->with(array('productos'=>$productos));
  }
  public function editarproducto($codigo)
  {
    //return $codigo;
    $categorias=DB::table('app_listas')->where('id_tipo_lista',4)->select('valor_lista','valor_item')->get();
    $productos=DB::table('app_productos')->where('codigo',$codigo)->take(1)->get();
    return View::make("productos.editarproducto")->with(array('productos'=>$productos,'categorias'=>$categorias));
  }

  public function editarproductointerno(Request $request)
  {
    if ($request->has('editarcodigo')) {
        $this->validate($request, [
          'codigo' => 'required|unique:app_productos,codigo',
      ]);
      $codigo=$request->codigo;
    }else {
        $this->validate($request, [
        ]);
      $codigo=$request->Codigo;
    }

    if ($request->hasfile('imagenes')) {
      $files=$request->imagenes;
      foreach ($files as $file) {
        $public = \Storage::disk('public');
        $imageFileName = mt_rand(1,2147) . '.' . $file->getClientOriginalExtension();
        $filePath =$imageFileName;
         $public->put('/'.$filePath, file_get_contents($file), 'public');
        $link_[]=$imageFileName;
      }
    }else {
      $link_[]="";
    }
    $linkviejo=DB::table('app_productos')->select('imagen')->where('codigo',$request->codigoprincipal)->take(1)->get();
    foreach ($linkviejo as $key) {
      $imagen=$key->imagen;
    }
    if (empty($imagen)) {
    $linki=implode(",",$link_);
  }else {
    $linki=implode(",",$link_).','.$imagen;
  }
  //echo $request->codigoprincipal;
  //return $codigo;
  DB::table('app_productos')->where('codigo',$request->codigoprincipal)->update(['nombre'=>strtoupper($request->nombre),'codigo'=>$codigo,
  'descripcion'=>strtoupper($request->descripcion),'vl_mayorista'=>$request->vrmayorista,'vl_minorista'=>$request->vrminorista,
  'imagen'=>$linki]);

  Session::flash('flash_message', 'se ha guardado el siguiente producto: ' .strtoupper($request->nombre));
  return redirect('producto/'.$codigo);
  }



}
