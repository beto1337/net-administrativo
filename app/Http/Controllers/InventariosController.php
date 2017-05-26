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

class InventariosController extends Controller
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

  public function inventarioform()
  {
    $categorias=DB::table('app_listas')->where('id_tipo_lista',4)->get();
    $productos=DB::table('app_productos')->get();
    $bodegas=DB::table('app_bodegas')->get();
  return View('inventario.inventarioform')->with(array('categorias'=>$categorias,'productos'=>$productos,'bodegas'=>$bodegas));
  }

  public function inventario(Request $request)
  {

  if ($request->button==1) {
  $productos=explode(",", $request->productos);
  $totales=explode(",", $request->total);
  $reservados=explode(",", $request->reservado);
  $bodegas=explode(",", $request->bodegas);
  $view =  \View::make('pdf.pdf')->with(array('productos' =>$productos,'reservados' =>$reservados,'totales' =>$totales,'iteracions' =>$request->iteraciones,'bodegas'=>$bodegas,'bodegasc'=>$request->bodegasc,'decide'=>'0'))->render();
  $pdf = \App::make('dompdf.wrapper');
  $pdf->loadHTML($view);
  return $pdf->stream('invoice');

  }elseif ($request->button==2) {
    $todo=$request->all();
    $productos=explode(",", $request->productos);
    $totales=explode(",", $request->total);
    $reservados=explode(",", $request->reservado);
    $view =  \View::make('pdf.pdf')->with(array('productos' =>$productos,'reservados' =>$reservados,'totales' =>$totales,'iteracions' =>$request->iteraciones,'s'=>$request->s,'decide'=>'1'))->render();
    $pdf = \App::make('dompdf.wrapper');
    $pdf->loadHTML($view);
    return $pdf->stream('invoice');
  }


    $this->validate($request, [
      'fecha' => 'required',
      ]);
  $todo=$request->all();
  $fechaini=$request->fecha . " 00:00:00";
  $fechafin=$request->fecha . " 23:59:00";
    if ($request->has('todasfecha')) {
    $this->validate($request, [
      'fecha_final' => 'required',
      ]);
      $fechafin=$request->fecha_final . " 23:59:00";
  }

  if ($request->has('todasb')) {
  $bo=DB::table('app_bodegas')->get();
  foreach ($bo as $value) {
    $bodega[]=$value->id;
  }
  $decide=0;
  }else {
    $this->validate($request, [
      'bodega' => 'required',
      ]);
      $bodega=$request->bodega;
      $decide=1;
  }
  if ($request->has('porcategoria')) {

    if ($request->has('todascategorias')) {
      $pro=DB::table('app_productos')->get();
      foreach ($pro as $value) {
        $producto[]=$value->codigo;
      }
      $cat=DB::table('app_listas')->where('id_tipo_lista',4)->count();
      $categ=DB::table('app_listas')->where('id_tipo_lista',4)->select('valor_lista')->get();
      foreach ($categ as $value) {
        $cate[]=$value->valor_lista;
      }
    }else {
      $this->validate($request, [
        'categoria' => 'required',
        ]);
        $pro=DB::table('app_productos')->whereIn('categoria',$request->categoria)->get();
        foreach ($pro as $value) {
          $producto[]=$value->codigo;
        }
    }
    $cat=count($request->categoria);
    $cate=$request->categoria;
  }else {

    if ($request->has('todasp')) {
      $pro=DB::table('app_productos')->get();
      foreach ($pro as $value) {
        $producto[]=$value->codigo;
      }
    }else {
      $this->validate($request, [
        'producto' => 'required',
        ]);
        $producto=$request->producto;
    }
  }

  for ($i=0; $i < count($producto); $i++) {
    for ($j=0; $j < count($bodega); $j++) {
      $totalp=0;
      $total=DB::table('app_movimientos')->where('producto_id', $producto[$i])->where('bodega',$bodega[$j] )->take(1)->orderby('creado','desc')->get();
      foreach ($total as $value) {
        $totalp=$value->total;
      }
  $cantidadinicial=0;
      $disponible=DB::table('app_reservas')->whereBetween('desde', [$fechaini,$fechafin])->where('bodega',$bodega[$j])->get();
  if (empty($disponible)) {
    $reservados[]=0;
  }else {
    foreach ($disponible as $value) {
        $productosre=$value->producto;
        $coincidencia = strpos($productosre, $producto[$i]);
      if (!($coincidencia === false)) {
       $produc=explode(",", $value->producto);
       $cant=explode(",", $value->cantidad);
       $position=array_search($productos[$i], $produc);
       $cantidadinicial=$cantidadinicial+$cant[$position];//aqui esta la cantidad reservada
    }
    }
    $reservados[]=$Ccantidadinicial;
    }
    $totalesf[]=$totalp;
  }
  }

  if ($request->has('bod')) {
    if ($request->bod==1) {
      $decide=1;
    }elseif ($request->bod==2) {
      $decide=2;
    }else {
      $decide=0;
    }


      }else {
    $decide=0;
  }


  return View::make('show.inventario')->with(array('productos' =>$producto,'reservados' =>$reservados,'totales' =>$totalesf,'iteracions' =>count($producto),'bodegas'=>$bodega,'bodegasc'=>count($bodega),'decide'=>$decide,'cat'=>$cat,'cate'=>$cate));

  }

}
