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
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class PedidosController extends Controller
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
    public function registrarpedido()
    {
      $productos=DB::table('app_productos')->select('codigo','nombre')->get();
      $clientes=DB::table('app_clientes')->select('id','nombre','apellido')->get();
      $bodegas=DB::table('app_bodegas')->select('id','nombre')->get();
      return View::make("pedidos.registrar")->with(array('productos'=>$productos,'clientes'=>$clientes,'bodegas'=>$bodegas));
    }
    public function generarguia(Request $request)
    {
      $reserva=DB::table('app_reservas')->where('id',$request->reserva)->get();
      $factura=DB::table('app_facturaciones')->where('id_reserva',$request->reserva)->orderby('id','desc')->take(1)->get();

      if ($request->generarfactura==1) {
        $id=$request->reserva;
        $view =  \View::make('pdf.factura')->with(array('orden' =>$reserva,'factura'=>$factura))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('invoice');


        }elseif ($request->generarfactura==2) {
          $id=DB::table('app_cotizaciones')->max('id');
          $reserva=DB::table('app_cotizaciones')->where('id',$id)->get();
           Excel::create('projects', function($excel) use($reserva) {
               $excel->sheet('Sheet 1', function($sheet) use($reserva) {
                 $sheet->loadView('pdf.guia', array('orden'=>$reserva));

     $sheet->setOrientation('portrait');
        });
           })->export('xls');
    }
  }
  public function cambiarestado(Request $request)
  {
$reserva=DB::table('app_reservas')->where('id',$request->reserva)->update(['estado'=>$request->estado+1]);
return back();
  }
    public function crearpedido(Request $request)
    {
      if ($request->has('cotizar')) {
        $this->validate($request, [
          'cantidad' => 'required|min:1',
          'tiempo' => 'required',
          'direccion'=>'required',
        ]);
        $tiempo=$request->tiempo;
        $fechaini=buscarfecha4(substr($tiempo, 0, 19));
        $fechafin=buscarfecha4(substr($tiempo, 22, 19));
        $cantidad=$request->cantidad;
        $productos=$request->producto;
        $bodega=$request->bodega_item;
        $productosguardar=implode(",", $productos);
        $cantidadguardar=implode(",",$cantidad);
        if ($request->has('Concepto')) {
          $concepto_descuentos=implode(",", $request->Concepto);
          $descuentos=implode(",", $request->descuento);
          $descuentos=str_replace('.','',$descuentos);
        }else {
          $concepto_descuentos="";
          $descuentos="";
        }
        if ($request->has('conceptoimpuesto')) {
          $concepto_impuesto=implode(",", $request->conceptoimpuesto);
          $impuesto=implode(",", $request->impuesto);
          $impuesto=str_replace('.','',$impuesto);
        }else {
          $concepto_impuesto="";
          $impuesto="";
        }

        if ($request->has('fecha_evento')) {
          $fecha_evento=str_replace('T',' ',$request->fecha_evento);
        }else {
          $fecha_evento=$fechaini;
        }

        DB::table('app_cotizaciones')->insert([['fecha_evento'=>$fecha_evento,'desde'=>$fechaini,'hasta'=>$fechafin,
        'producto'=>$productosguardar,'cantidad'=>$cantidadguardar,'bodega'=>$bodega,
        'estado'=>$request->estado,'cliente'=>$request->cliente,'recepcion'=>$request->direccion,
        'concepto_descuento'=>$concepto_descuentos,'descuento'=>$descuentos,'concepto_impuesto'=>$concepto_impuesto,
        'impuesto'=>$impuesto]]);
        $id=DB::table('app_cotizaciones')->max('id');
        $reserva=DB::table('app_cotizaciones')->where('id',$id)->get();
        $view =  \View::make('pdf.guia')->with(array('orden' =>$reserva))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf = PDF::loadView('pdf.guia',array('orden'=>$reserva));
        return $pdf->stream();
        $pdf->loadHTML($view);
        $pdf->stream();

      }
      $this->validate($request, [
        'cantidad' => 'required',
        'tiempo' => 'required',
        'direccion'=>'required',
        'bodega_item'=>'required',
        'abono'=>'required',
      ]);
      $abono=str_replace('.','',$request->abono);
      $tiempo=$request->tiempo;
      $fechaini=buscarfecha3(substr($tiempo, 0, 19));
      $fechafin=buscarfecha3(substr($tiempo, 22, 19));

      $cantidad=$request->cantidad;
      $productos=$request->producto;
      $bodega=$request->bodega_item;
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
        $disponible=DB::table('app_reservas')
        ->whereIn('estado',[1, 2, 3, 4, 5])
        ->Where(function ($query)
         {
           $tiempo=$_POST['tiempo'];
           $fechaini=buscarfecha3(substr($tiempo, 0, 19));
           $fechafin=buscarfecha3(substr($tiempo, 22, 19));
           $query->whereBetween('desde', [$fechaini, $fechafin])
           ->orwhereBetween('hasta', [$fechaini, $fechafin]);
         })->get();
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

      if ($request->has('Concepto')) {
        $this->validate($request, [
          'Concepto' => 'required',
        ]);
        $concepto_descuentos=implode(",", $request->Concepto);
        $descuentos=implode(",", $request->descuento);
        $descuentos=str_replace('.','',$descuentos);
      }else {
        $concepto_descuentos="";
        $descuentos="";
      }
      if ($request->has('conceptoimpuesto')) {
        $concepto_impuesto=implode(",", $request->conceptoimpuesto);
        $impuesto=implode(",", $request->impuesto);
        $impuesto=str_replace('.','',$impuesto);
      }else {
        $concepto_impuesto="";
        $impuesto="";
      }

      if ($request->has('fecha_evento')) {
        $fecha_evento=str_replace('T',' ',$request->fecha_evento);
      }else {
        $fecha_evento=$fechaini;
      }
      $totalfacturado=valorfactura($productosguardar,$cantidadguardar,$request->cliente);
      $totalrestante=$totalfacturado-$abono;
      DB::table('app_reservas')->insert([['fecha_evento'=>$fecha_evento,'desde'=>$fechaini,'hasta'=>$fechafin,
      'producto'=>$productosguardar,'cantidad'=>$cantidadguardar,'bodega'=>$bodega,
      'estado'=>$request->estado,'recepcion'=>$request->direccion,'cliente'=>$request->cliente]]);
      $id = DB::table('app_reservas')->max('id');
      DB::table('app_facturaciones')->insert([['id_reserva'=>$id,'concepto_descuentos'=>$concepto_descuentos,
      'descuentos'=>$descuentos,'concepto_impuestos'=>$concepto_impuesto,'impuestos'=>$impuesto,
      'fecha_abono'=>Carbon::now(),'total_abonado'=>$abono,'abono'=>$abono,'total_facturado'=>$totalfacturado,'total_restante'=>$totalrestante]]);

      Session::flash('flash_message', 'Reserva exitosa' );
      return redirect('orden  /'.$id);

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
  $fechaini=buscarfecha(substr($tiempo, 0, 10));
  $disponible=DB::table('app_reservas')
  ->whereIn('estado',[1, 2, 3, 4, 5])
  ->Where(function ($query)
   {
     $tiempo=$_GET['tiempo'];
     $fechaini=buscarfecha(substr($tiempo, 0, 10));
     $fechafin=buscarfecha(substr($tiempo, 11, 10));
     $query->whereBetween('desde', [$fechaini, $fechafin])
     ->orwhereBetween('hasta', [$fechaini, $fechafin]);
   })->get();

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
  public function ver($id)
  {
      $valores=DB::table('app_facturaciones')->where('id_reserva',$id)->orderby('id','desc')->take(1)->get();
      $reserva=DB::table('app_reservas')->where('id',$id)->get();
      return View::make("pedidos.pedido")->with(array('reserva'=>$reserva,'valores'=>$valores));
  }

function registrarabono(Request $request)
{
  if ($request->has('abono')) {
    $this->validate($request, ['Abono' => 'required',]);
  }
  $id=$request->id;
  $facturas=DB::table('app_facturaciones')->where('id_reserva',$id)->orderby('id','desc')->take(1)->get();
  foreach ($facturas as $key) {
    $saldo=$key->total_restante;
}
$abono=str_replace('.','',$request->Abono);


  if ($abono > $saldo) {
  Session::flash('error_message',' El abono no puede superar los $'.number_format($saldo).' pesos' );
  return back();
}else {
  foreach ($facturas as $value) {
$concepto_descuentos=$value->concepto_descuentos;
$descuentos=$value->descuentos;
$concepto_impuesto=$value->concepto_impuestos;
$impuesto=$value->impuestos;
$abonototal=$value->total_abonado;
$totalfacturado=$value->total_facturado;
$totalrestante=$value->total_restante;
}
$totaldesc=0;
$recargos=0;
if ($request->has('Concepto')) {
  $this->validate($request, [
    'Concepto' => 'required',
  ]);
  if ($concepto_descuentos=="") {
$concepto_descuentos=implode(",", $request->Concepto);
  }else {
    $concepto_descuentos=implode(",", $request->Concepto).",".$concepto_descuentos;
    }
    if ($descuentos=="") {
$descuentos=implode(",", $request->descuento);
    }else {
  $descuentos=implode(",", $request->descuento).",".$descuentos;
  $d=$request->descuento;
  $cont=count($d);
  for ($i=0; $i < $cont ; $i++) {
    $d[$i]=str_replace('.','',$d[$i]);
    $totaldesc=$totaldesc+$d[$i];
  }
  }
$descuentos=str_replace('.','',$descuentos);
}
if ($request->has('conceptoimpuesto')) {
  if ($concepto_impuesto=="") {
    $concepto_impuesto=implode(",", $request->conceptoimpuesto);
  }else {
  $concepto_impuesto=implode(",", $request->conceptoimpuesto).",".$concepto_impuesto;
  }
if ($impuesto=="") {
  $impuesto=implode(",", $request->impuesto);
}else {
  $impuesto=implode(",", $request->impuesto).",".$impuesto;
  $imp=$request->impuesto;
  $contim=count($imp);
  for ($i=0; $i < $contim ; $i++) {
    $imp[$i]=str_replace('.','',$imp[$i]);
    $recargos=$recargos+$imp[$i];
  }
}
  $impuesto=str_replace('.','',$impuesto);
}

$abonototal=$abonototal+$abono;
$totalrestante=$totalrestante-$abono-$totaldesc+$recargos;
  DB::table('app_facturaciones')->insert([['id_reserva'=>$id,'concepto_descuentos'=>$concepto_descuentos,
  'descuentos'=>$descuentos,'concepto_impuestos'=>$concepto_impuesto,'impuestos'=>$impuesto,
  'fecha_abono'=>Carbon::now(),'total_abonado'=>$abonototal,'abono'=>$abono,'total_facturado'=>$totalfacturado,'total_restante'=>$totalrestante]]);
  Session::flash('flash_message', ' Transaccion Registrada' );
  return back();
}
}
}
