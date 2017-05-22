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
class StorageController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {    $this->middleware('auth');}




public function editarproducto(Request $request)
{
$codigo=DB::table('app_productos')->where('id',$request->id)->take(1)->get();
foreach ($codigo as $value) {
  $codigo=$value->codigo;
  $link=$value->imagenes;
}
  if ($request->hasfile('kartik-input-700')) {
    $files=$request->file('kartik-input-700');
    foreach ($files as $file) {
      $s3 = \Storage::disk('s3');
      $imageFileName = mt_rand(1,2147) . '.' . $file->getClientOriginalExtension();
      $filePath = '/'.$codigo.'/' . $imageFileName;
      $s3->put($filePath, file_get_contents($file), 'public');
      $link_req[]='https://s3-sa-east-1.amazonaws.com/app-loung'.$filePath;
    }
  $linki=implode(",",$link_req);
  }else {
    $link=",";
    return "no tiene";
  }
  $link=$link.",".$link;
DB::table('app_productos')->where('id', $request->id)->update(['nombre' => strtoupper($request->nombre),'descripcion'=>strtoupper($request->ciudad),'vl_minorista'=>$request->vrminorista,'vl_mayorista'=>$request->vrmayorista]);
Session::flash('flash_message', 'Se ha  modificado el producto: ' .strtoupper($request->nombre));
return back();
}
public function registrarbodega(Request $request)
{
  $this->validate($request, ['nombre' => 'required','ciudad' => 'required','direccion' => 'required','telefono' => 'required',]);
  $todo=$request->all();
  $contador1=DB::table('app_bodegas')->where('nombre',$todo['nombre'])->where('ciudad',$todo['ciudad'])->count();
  $contador2=DB::table('app_bodegas')->where('ciudad',$todo['ciudad'])->where('direccion',$todo['direccion'])->count();
  if ($contador1>0 or $contador2>0) {
    Session::flash('flash_message', 'Ya existe una bodega con estas catracteristicas');
    return back();
    }
DB::table('app_bodegas')->insert([['nombre'=>strtoupper($todo['nombre']),'ciudad'=>strtoupper($todo['ciudad']),'direccion'=>strtoupper($todo['direccion']),'telefono'=>$todo['telefono']]]);
Session::flash('flash_message', 'se ha guardado la bodega: ' .strtoupper($todo['nombre']));
return back();
}
public function editarbodega(Request $request)
{
DB::table('app_bodegas')->where('id', $request->id)->update(['nombre' => strtoupper($request->nombre),'ciudad'=>strtoupper($request->ciudad),'direccion'=>strtoupper($request->direccion),'telefono'=>$request->telefono]);
Session::flash('flash_message', 'Se ha guardado modificado la bodega: ' .strtoupper($request->nombre));
return back();
}
public function registrarcliente(Request $request)
{
$this->validate($request, [
  'nombre' => 'required',
  'apellido' => 'required',
  'cedula' => 'required|numeric',
  'telefono' => 'required',
  'celular'=>'required',
  'correo' => 'required|email|unique:app_clientes',
  'direccion' => 'required',]);

$contador1=DB::table('app_clientes')->where('cedula',$request->cedula)->count();
if ($contador1>0) {
Session::flash('flash_message', 'Ya existe un usuario registrado con este numero de cedula');
return back();
}
DB::table('app_clientes')->insert([['nombre'=>strtoupper($request->nombre),'apellido'=>strtoupper($request->apellido),
'cedula'=>$request->cedula,'telefono'=>$request->telefono,'celular'=>$request->celular,
'correo'=>$request->correo,'direccion'=>$request->direccion,'tipo'=>$request->tipo]]);
Session::flash('flash_message', 'se ha guardado el cliente: ' .strtoupper($request->nombre)." ".strtoupper($request->apellido));
return back();
}
public function editarcliente(Request $request)
{
  DB::table('app_clientes')->where('id', $request->id)->update([
    'nombre'=>strtoupper($request->nombre),'apellido'=>strtoupper($request->apellido),
    'telefono'=>$request->telefono,'celular'=>$request->celular,
    'correo'=>$request->correo,'direccion'=>$request->direccion,'tipo'=>$request->tipo
  ]);
  Session::flash('flash_message', 'Se ha modificado el cliente: ' .strtoupper($request->nombre)." ".strtoupper($request->apellido));
  return back();
}
public function registromovimiento(Request $request)
{
  $todo=$request->all();
  $productos=$request->producto;
  $cantidades=$request->cantidad;
  $id_m=DB::table('app_movimientos')->max('id_m');
  $id_m=$id_m+1;
  for ($i=0; $i < count($productos); $i++) {

  if (Auth::user()->id_perfil==1) {
    if ($request->item==1 or $request->item==2) {
      if ($request->bodega_item==0) {
        Session::flash('error_message', 'Debe seleccionar una bodega');
        return back();
      }
        $bodega=$request->bodega_item;
  }
  }else {
    $bodega=Auth::user()->bodega_id;
  }
  $this->validate($request, [
    'producto' => 'required',
    'item' => 'required',
    'descripcion' => 'required',
    'cantidad' => 'required|min:1',
    ]);
    $totales="";
  if ($request->item==1) {
    $total=DB::table('app_movimientos')->where('producto_id', $productos[$i])->where('bodega',$bodega)->take(1)->orderby('creado','desc')->get();
    foreach ($total as $value) {
      $totales=$value->total;
    }
    if ($totales=="") {
      $totales=0;
    }
    DB::table('app_movimientos')->insert([['id_m'=>$id_m,'producto_id'=>$productos[$i],'item'=>$request->item,
    'descripcion'=>$request->descripcion,'cantidad'=>$cantidades[$i],'bodega'=>$bodega,'total'=>$totales+$cantidades[$i],
    'bodega_entrada'=>0,'creado'=>Carbon::now()]]);
  }elseif ($request->item==2) {
    for ($j=0; $j < count($productos); $j++) {

          $total=DB::table('app_movimientos')->where('producto_id', $productos[$j])->where('bodega',$bodega)->take(1)->orderby('creado','desc')->get();
          foreach ($total as $value) {
            $totales=$value->total;
          }
          if ($totales=="") {
            $totales=0;
          }

          if ($cantidades[$j]>$totales) {
            Session::flash('error_message', 'El producto '.validarproductoporcodigo($productos[$j])." solo tiene ".$totales." unidades disponibles para salida");
            return back();
          }
    }


      DB::table('app_movimientos')->insert([['id_m'=>$id_m,'producto_id'=>strtoupper($productos[$i]),'item'=>strtoupper($request->item),
      'descripcion'=>$request->descripcion,'cantidad'=>$cantidades[$i],'bodega'=>$bodega,'total'=>$totales-$cantidades[$i],
      'bodega_entrada'=>0,'creado'=>Carbon::now()]]);

  }elseif ($request->item==3) {
  if ($request->bodega_salida==0 or $request->bodega_entrada==0) {
    Session::flash('error_message', 'Debe seleccionar una bodega en cada campo');
    return back();
  }
  if ($request->bodega_salida==$request->bodega_entrada) {
    Session::flash('error_message', 'La bodega de destino debe ser diferente a la de salida');
    return back();
  }

  for ($j=0; $j < count($productos); $j++) {

        $total=DB::table('app_movimientos')->where('producto_id', $productos[$j])->where('bodega',$request->bodega_entrada)->take(1)->orderby('creado','desc')->get();
        foreach ($total as $value) {
          $totales=$value->total;
        }
        if ($totales=="") {
          $totales=0;
        }

        if ($cantidades[$j]>$totales) {
          Session::flash('error_message', 'El producto '.validarproductoporcodigo($productos[$j])." solo tiene ".$totales." unidades disponibles para traslado");
          return back();
        }
  }
    DB::table('app_movimientos')->insert([['id_m'=>$id_m,'producto_id'=>$productos[$i],'item'=>$request->item,
    'descripcion'=>$request->descripcion,'cantidad'=>$cantidades[$i],'bodega'=>$request->bodega_salida,'bodega_entrada'=>$request->bodega_entrada,
    'total'=>$total-$cantidades[$i],'creado'=>Carbon::now()]]);

    DB::table('app_movimientos')->insert([['id_m'=>$id_m,'producto_id'=>$productos[$i],'item'=>2,
    'descripcion'=>'salen productos por traslado','cantidad'=>$cantidades[$i],'bodega'=>$request->bodega_salida,'total'=>$total-$cantidades[$i],
    'bodega_entrada'=>0,'creado'=>Carbon::now()]]);
    $total=DB::table('app_movimientos')->where('producto_id',$productos[$i] )->where('bodega',$request->bodega_entrada)->take(1)->orderby('creado','desc')->get();
    foreach ($total as $value) {
      $total=$value->total;
    }
    if (empty($total)) {
      $total=0;
    }
    DB::table('app_movimientos')->insert([['id_m'=>$id_m,'producto_id'=>$productos[$i],'item'=>1,
    'descripcion'=>'entran productos por traslado','cantidad'=>$cantidades[$i],'bodega'=>$request->bodega_entrada,'total'=>$total+$cantidades[$i],
    'bodega_entrada'=>0,'creado'=>Carbon::now()]]);


  }
}
Session::flash('flash_message', 'se ha registrado un movimiento: ');
return back();


}
public function registrarreserva(Request $request)
{

  $bodega=$request->bodega_item;
  if ($bodega ==0) {
    Session::flash('error_message', "debe seleccionar una bodega" );
    return back();
    }
  $this->validate($request, [
    'cantidad' => 'required',
    'tiempo' => 'required',
    'direccion'=>'required',
  ]);
  $tiempo=$request->tiempo;

  $fechaini=buscarfecha2(substr($tiempo, 0, 17));
  $fechafin=buscarfecha2(substr($tiempo, 18, 17));


  $cantidad=$request->cantidad;
  $productos=$request->producto;
  for ($i=0; $i < count($request->producto) ; $i++) {
    $totalp="";
    $total=DB::table('app_movimientos')->where('producto_id', $productos[$i])->where('bodega',$bodega )->take(1)->orderby('creado','desc')->get();
    foreach ($total as $value) {
      $totalp=$value->total;
    }
    if (empty($total)) {
      Session::flash('error_message', 'El producto '. validarproductoporcodigo($productos[$i]). " no registra suficientes unidades disponibles" );
      return back();
    }



    $disponible=DB::table('app_reservas')->whereBetween(['desde', [$fechaini, $fechafin]],['hasta', [$fechaini, $fechafin]])->where('bodega')->get();
    foreach ($disponible as $value) {
        $cantidadinicial=0;
      $productosre=$value->producto;
      $coincidencia = strpos($productosre, $productos[$i]);
      if (!($coincidencia === false)) {
       $produc=explode(",", $value->producto);
       $cant=explode(",", $value->cantidad);
       $position=array_search($productos[$i], $produc);
       $cantidadinicial=$cantidadinicial+$cant[$position];//aqui esta la cantidad reservada
       $totalp=$totalp-$cantidadinicial;
if ($cantidad[$i]> $totalp) {
  Session::flash('error_message', 'Solo exiten '.$totalp.' '. validarproductoporcodigo($productos[$i]). ' disponibles entre estas fechas' );
  return back();
  }
    }
    }
  }

  $productosguardar=implode(",", $productos);
  $cantidadguardar=implode(",",$cantidad);
  DB::table('app_reservas')->insert([['desde'=>$fechaini,'hasta'=>$fechafin,'producto'=>$productosguardar,'cantidad'=>$cantidadguardar,'bodega'=>$bodega]]);
  Session::flash('flash_message', 'Reserva exitosa' );
  return back();

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
  $view =  \View::make('pdf.pdf')->with(array('productos' =>$productos,'reservados' =>$reservados,'totales' =>$totales,'iteracions' =>$request->iteraciones,'bodegas'=>$request->bodegas,'decide'=>'1'))->render();
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
return View::make('show.inventario')->with(array('productos' =>$producto,'reservados' =>$reservados,'totales' =>$totalesf,'iteracions' =>count($producto),'bodegas'=>$bodega,'bodegasc'=>count($bodega),'decide'=>$decide));

}
}