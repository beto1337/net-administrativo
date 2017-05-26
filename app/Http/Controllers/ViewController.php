<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use View;
use DB;
use Auth;

class ViewController extends Controller
{








  public function entradaproducto()
  {
    $items=DB::table('app_listas')->where('id_tipo_lista',1)->get();
    $bodegas=DB::table('app_bodegas')->get();
    $productos=DB::table('app_productos')->orderby('nombre','desc')->get();
    return View::make("register.entradaproducto")->with(array('productos'=>$productos,'items'=>$items,'bodegas'=>$bodegas));
  }
  public function salidaproducto()
  {
    $productos=DB::table('app_productos')->get();
    $items=DB::table('app_listas')->where('id_tipo_lista',1)->get();
    return View::make("register.salidaproducto")->with(array('productos'=>$productos,'items'=>$items));
  }
  public function registrarreserva()
  {
    $productos=DB::table('app_productos')->get();
    $clientes=DB::table('app_clientes')->get();
    $bodegas=DB::table('app_bodegas')->get();
    return View::make("register.registrarreserva")->with(array('productos'=>$productos,'clientes'=>$clientes,'bodegas'=>$bodegas));
  }
  public function confirmar1()
  {
    $producto=$_GET['productid'];
    $cantidad=$_GET['cantidad'];
    $bodega=$_GET['bodega'];
    $tiempo=$_GET['tiempo'];
    $fechaini=buscarfecha2(substr($tiempo, 0, 17));
    $fechafin=buscarfecha2(substr($tiempo, 18, 17));


    $ini=0;
    $total=DB::table('app_movimientos')->where('producto_id', $producto)->where('bodega',$bodega )->take(1)->orderby('creado','desc')->get();
    $productosf=DB::table('app_productos')->where('codigo', $producto)->take(1)->get();
    foreach ($productosf as $value) {
      $productosfinal=$value->nombre;
      $codigosf=$value->codigo;
    }
    foreach ($total as $value) {
      $ini=$value->total;
    }

    $totales=$ini;
    $cantidadreservada=0;
    $disponible=DB::table('app_reservas')->whereBetween('desde', [$fechaini, $fechafin])->orwhereBetween('hasta', [$fechaini, $fechafin])->get();
    foreach ($disponible as $value) {
      $productosre=$value->producto;
      $coincidencia = strpos($productosre, $producto);
      if (!($coincidencia === false)) {
        $produc=explode(",", $value->producto);
        $cant=explode(",", $value->cantidad);
        $position=array_search($producto, $produc);
        $cantidadreservada=$cantidadreservada+$cant[$position];
     }
    }
    $disponibles=$ini-$cantidadreservada;
    if ($cantidad>$disponibles) {
    echo "<p style='color:red'>".$disponibles ." disponibles para alquiler en las fechas seleccionadas<p>";
    }else {
    echo $cantidadreservada ." productos reservados de ".$totales." en inventario";
     }
  }
  public function confirmar()
  {
$producto=$_GET['productid'];
$cantidad=$_GET['cantidad'];
$bodega=$_GET['bodega'];
$tiempo=$_GET['tiempo'];
if (empty($tiempo)) {
  return '
  <div class="alert alert-danger alert-dismissable fade in">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Lo sentimos! </strong> Debes seleccionar un rango de tiempo
  </div>';
}
$fechaini=buscarfecha(substr($tiempo, 0, 10));
$fechafin=buscarfecha(substr($tiempo, 11, 10));
$productoscod=str_replace("-",",",$producto);
$productoscod=substr($productoscod, 0, -1);
$productoscod=explode(",",$productoscod);
//$productos=DB::table('app_productos')->whereIn('codigo',$productoscod)->get();
for ($i=0; $i < count($productoscod) ; $i++) {
$ini=0;

$total=DB::table('app_movimientos')->where('producto_id', $productoscod[$i])->where('bodega',$bodega )->take(1)->orderby('creado','desc')->get();
$productosf=DB::table('app_productos')->where('codigo', $productoscod[$i])->take(1)->get();
foreach ($productosf as $value) {
  $productosfinal[]=$value->nombre;
  $codigosf[]=$value->codigo;
}
foreach ($total as $value) {
  $ini=$value->total;
}
$totales[]=$ini;
$cantidadreservada=0;
$disponible=DB::table('app_reservas')->whereBetween('desde', [$fechaini, $fechafin])->orwhereBetween('hasta', [$fechaini, $fechafin])->get();
foreach ($disponible as $value) {
  $productosre=$value->producto;
  $coincidencia = strpos($productosre, $productoscod[$i]);
  if (!($coincidencia === false)) {
   $produc=explode(",", $value->producto);
   $cant=explode(",", $value->cantidad);
   $position=array_search($productoscod[$i], $produc);
   $cantidadreservada=$cantidadreservada+$cant[$position];
 }
}
$cantidadtotalreservada[]=$cantidadreservada;

}
$contador=count($productoscod);
return View::make("show.confirmar")->with(array('productos'=>$productosfinal,'reservada'=>$cantidadtotalreservada,'total'=>$totales,'codigos'=>$codigosf,'iteracions'=>$contador));
}

public function movimientos()
{
  $movimientos=DB::table('app_movimientos')->groupBy('id_m')->get();
  return View::make("show.movimientos")->with(array('movimientos'=>$movimientos));

}
public function direccioncliente()
{
$id=$_GET['id'];
$cliente=DB::table('app_clientes')->select('direccion')->where('id',$id)->take(1)->get();
foreach ($cliente as $value) {
  $direccion=$value->direccion;
}
echo "<label style='color:black'>".$direccion."</label>";
}
public function movimientoid()
{
$id=$_GET['id'];
$movimientos=DB::table('app_movimientos')->where('id_m',$id)->get();
foreach ($movimientos as $value) {
  $descripcion=$value->descripcion;
  break;
}
return View('show.movimiento')->with(array('movimientos'=>$movimientos,'descripcion'=>$descripcion));
}




}
