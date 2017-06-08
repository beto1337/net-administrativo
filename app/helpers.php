<?php
use Carbon\Carbon;
function validarproducto($id){
  if (empty($id)) {
return "";
  }else {
$producto=DB::table('app_productos')->select('nombre')->where('id',$id)->take(1)->get();
foreach ($producto as $product) {
  $producto=$product->nombre;
}
return $producto;
}
}
function validarproductoporcodigo($id){
  if (empty($id)) {
return "";
  }else {
$producto=DB::table('app_productos')->select('nombre')->where('codigo',$id)->take(1)->get();
foreach ($producto as $product) {
  $producto=$product->nombre;
}
return $producto;
}
}

function productos($codigos, $cantidades,$cliente)
{
  $codigos=explode(',',$codigos);
  $cantidades=explode(',',$cantidades);
  $contador=count($codigos);
  $categorias=DB::table('app_listas')->where('id_tipo_lista',4)->get();
  $contadorcategorias=DB::table('app_listas')->where('id_tipo_lista',4)->count();
  foreach ($categorias as $categoria) {
    $cat=0;
      for ($i=0; $i < $contador ; $i++) {
        if (buscarcategoria($codigos[$i],$categoria->valor_lista)) {
          if ($cat==0) {
            echo "<thead >
            <tr>
            <th colspan='5' style='text-align:center;padding:10px;border-radius: 0px;FONT-SIZE:20px'>".$categoria->valor_item."</th>

            </tr>".
              "
              <tr>
              <th style='text-align: center'>Codigo</th>
              <th style='text-align: center'>Producto</th>
              <th style='text-align: center'>Cantidad</th>
              <th style='text-align: center'>".precioporcliente($cliente,1)."</th>
              <th style='text-align: center'>Total</th>
              </tr>
              </thead>";
          }
          $cat=1;
          $prod=validarproductoporcodigo($codigos[$i]);
          echo "<tr><td>".$codigos[$i].'</td>'.
          "<td>".$prod.'</td>'.
          "<td>".$cantidades[$i].'</td>'.
          "<td> $ ".number_format(validarprecio($codigos[$i],$cliente)).'</td>'.
          "<td> $ ".number_format($cantidades[$i]*validarprecio($codigos[$i],$cliente)).'</td>'.
          '</tr>'
          ;
        }
      }
  }
}
function validarprecio($codigo,$cliente)
{
$caso=cliente($cliente,4);
if ($caso==1) {
$item="vl_minorista";
}elseif ($caso==2) {
$item="vl_mayorista";
}

$producto=DB::table('app_productos')->where('codigo',$codigo)->select($item)->take(1)->get();
foreach ($producto as $key) {
  return $key->$item;
}
}

function buscarcategoria($codigo,$categoria)
{
$producto=DB::table('app_productos')->where('codigo',$codigo)->where('categoria',$categoria)->count();
if ($producto==0) {
  return false;
}else {
  return true;
}
}



function validarlista($id,$lista){
  if (empty($id)) {
return "";
  }else {
$producto=DB::table('app_listas')->select('valor_item')->where('id_tipo_lista',$lista)->where('valor_lista',$id)->take(1)->get();
foreach ($producto as $product) {
  $producto=$product->valor_item;
}
return $producto;
}
}
function buscarfecha($tiempo)
{
  $año = substr($tiempo, 6, 4);
  $mes = substr($tiempo, 0, 2);
  $dia = substr($tiempo, 3, 2);
  return $año."-".$mes."-".$dia;
}

function buscarfecha3($tiempo)
{
  $año = substr($tiempo, 6, 4);
  $mes = substr($tiempo, 3, 2);
  $dia = substr($tiempo, 0, 2);
  $horas=substr($tiempo,11, 5);
  $a=substr($tiempo,17, 2);
  $hora=substr($tiempo,11, 2);
  //return $hora;
  if ($a=='AM') {
    if ($hora==12) {
    $horas='00:'.substr($tiempo,13, 2).':00';
    }else {
      $horas=$horas.":00";
    }

  }else {
  if ($hora==12) {
  $horas=$horas.":00";
  }else {
    $hora=$hora+12;
    $horas=$hora.":".substr($tiempo,14, 2).":00";
  }
  }
  return $año."-".$mes."-".$dia." ".$horas;
}
function buscarfecha4($tiempo)
{
  $año = substr($tiempo, 6, 4);
  $mes = substr($tiempo, 3, 2);
  $dia = substr($tiempo, 0, 2);
  $horas=substr($tiempo,11, 5);
  $a=substr($tiempo,17, 2);
  $hora=substr($tiempo,11, 2);
  //return $hora;
  if ($a=='AM') {
    if ($hora==12) {
    $horas='00:'.substr($tiempo,13, 2).':00';
    }else {
      $horas=$horas.":00";
    }

  }else {
  if ($hora==12) {
  $horas=$horas.":00";
  }else {
    $hora=$hora+12;
    $horas=$hora.":".substr($tiempo,13, 2).":00";
  }
  }
  return $año."-".$mes."-".$dia." ".$horas;
}

function buscarfecha2($tiempo)
{
  $año = substr($tiempo, 6, 4);
  $mes = substr($tiempo, 3, 2);
  $dia = substr($tiempo, 0, 2);
  $horas=substr($tiempo,10, 5);
  $a=substr($tiempo,15, 2);
  $hora=substr($tiempo,10, 2);

  if ($a=='AM') {
    if ($hora==12) {
    $horas='00:'.substr($tiempo,13, 2).':00';
    }else {
      $horas=$horas.":00";
    }

  }else {
  if ($hora==12) {
  $horas=$horas.":00";
  }else {
    $hora=$hora+12;
    $horas=$hora.":".substr($tiempo,13, 2).":00";
  }
  }
  return $año."-".$mes."-".$dia." ".$horas;
}

function validarbodega($id)
{
  if (empty($id)) {
return"";
  }else {
$producto=DB::table('app_bodegas')->select('nombre')->where('id',$id)->take(1)->get();
foreach ($producto as $product) {
  $producto=$product->nombre;
}
return $producto;
}
}
function buscarimagenes($link,$codigo)
{
if (empty($link)) {
echo "<label>no hay imagenes para mostrar</label>";
}else {
$links = explode(",", $link);
for ($i=0; $i <count($links) ; $i++) {
echo '<div class="col-md-4"><div class="thumbnail">';
echo '<img src="'.rutaimagenes().'/'.$links[$i].'" alt="" class=" img-responsive" width="100%">';
echo "</div></div>";
}
}
}
function quehace($valor)
{
if ($valor<3) {
return $valor;
}
return quehace($valor-1)*quehace($valor-2);
}
function rutaimagenes()
{
return "http://localhost/net-administrativo/storage/app/public";
}

function cliente($id,$caso)
{
  //caso=1->nombre del cliente
  //caso=2->correo del cliente
  //caso=3->telefono del cliente
if ($caso==1) {
  $item="nombre";
}elseif ($caso==2) {
$item="correo";
}elseif ($caso==3) {
$item="telefono";
}elseif ($caso==4) {
$item="tipo";
}
$cliente=DB::table('app_clientes')->select($item)->where('id',$id)->take(1)->get();
foreach ($cliente as $cliente) {
  $valor=$cliente->$item;
  return $valor;
}
}
function buscarproductos($codigos,$cantidades,$cliente)
{
  $codigos=explode(',',$codigos);
  $cantidades=explode(',',$cantidades);
  $contador=count($codigos);
  $categorias=DB::table('app_listas')->where('id_tipo_lista',4)->get();
  $contadorcategorias=DB::table('app_listas')->where('id_tipo_lista',4)->count();
  foreach ($categorias as $categoria) {
    $totalcategoria=0;
    $cat=0;
      for ($i=0; $i < $contador ; $i++) {
        if (buscarcategoria($codigos[$i],$categoria->valor_lista)) {
          if ($cat==0) {
            echo '<table style="width:100%;margin: 10px 0px 10px 0px;">
              <thead style="background-color:#792929;color:white">
                <tr class="center-block">
                  <th colspan="5" style="text-align:center;padding:4px;border-radius: 0px;FONT-SIZE: 15px;" >'.$categoria->valor_item.'</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th style="text-align:center">CANTIDAD</th>
                  <th style="text-align:center">CODIGO</th>
                  <th style="text-align:center">PRODUCTO</th>
                  <th style="text-align:center">PRECIO</th>
                  <th style="text-align:center">TOTAL</th>
                </tr>';
          }
          $cat=1;
          $prod=validarproductoporcodigo($codigos[$i]);
          echo "<tr><td style='text-align:center;FONT-SIZE: 10px'>".$cantidades[$i].'</td>'.
          "<td style='text-align:center;FONT-SIZE: 12px'>".$codigos[$i].'</td>'.
          "<td style='text-align:center;FONT-SIZE: 12px'>".$prod.'</td>'.
          "<td style='text-align:center;FONT-SIZE: 12px'>$ ".number_format(validarprecio($codigos[$i],$cliente)).'</td>'.
          "<td style='text-align:center;FONT-SIZE: 12px'>$ ".number_format($cantidades[$i]*validarprecio($codigos[$i],$cliente)).'</td>'.
          '</tr>';
          $totalcategoria=$totalcategoria+($cantidades[$i]*validarprecio($codigos[$i],$cliente));
        }
      }
      echo "</tbody>
            </table>";
  }

}
function formatofecha($fecha)
{
  $fecha=Carbon::parse($fecha);
  $fecha=$fecha->format('l jS  F  h:i:s A');
  $fecha=str_replace("st","",$fecha);
  $fecha=str_replace("th","",$fecha);
  $fecha=str_replace("rd  ","",$fecha);
  $fecha=cambiardia($fecha);
  $fecha=Cambiarmes($fecha);
  return $fecha;
}
function cambiardia($fecha)
{
  $fecha=str_replace("Monday","Lunes",$fecha);
  $fecha=str_replace("Tuesday","Martes",$fecha);
  $fecha=str_replace("Wednesday","Miercoles",$fecha);
  $fecha=str_replace("Thursday","Jueves",$fecha);
  $fecha=str_replace("Friday","Viernes",$fecha);
  $fecha=str_replace("Saturday","Sabado",$fecha);
  $fecha=str_replace("Sunday","Domingo",$fecha);
  return $fecha;
}
function cambiarmes($fecha)
{
  $fecha=str_replace("January","Enero",$fecha);
  $fecha=str_replace("February","Febrero",$fecha);
  $fecha=str_replace("March","Marzo",$fecha);
  $fecha=str_replace("April","Abril",$fecha);
  $fecha=str_replace("May","Mayo",$fecha);
  $fecha=str_replace("June","Junio",$fecha);
  $fecha=str_replace("July","Julio",$fecha);
  $fecha=str_replace("August","Agosto",$fecha);
  $fecha=str_replace("September","Septiembre",$fecha);
  $fecha=str_replace("October","Octubre",$fecha);
  $fecha=str_replace("November","Noviembre",$fecha);
  $fecha=str_replace("December","Diciembre",$fecha);
  return $fecha;
}
function precioporcliente($cliente,$caso)
{
  //caso=1 mostramos vl mayorista o minorista
  if ($caso==1) {
    $show=cliente($cliente,4);
    if ($show==1) {
      return "V. MINORISTA";
    }else {
return "V. MAYORISTA";
  }
  }
}
  function resumen($codigos,$cantidades,$cliente,$concepto_descuento,$descuento,$concepto_impuesto,$impuesto)
{

  $codigos=explode(',',$codigos);
  $cantidades=explode(',',$cantidades);
  $contador=count($codigos);
  $categorias=DB::table('app_listas')->where('id_tipo_lista',4)->get();
  $contadorcategorias=DB::table('app_listas')->where('id_tipo_lista',4)->count();
$totalsuma=0;
  foreach ($categorias as $categoria) {
    $cat=0;
    $total=0;
    $cantidadporcategoria=0;

      for ($i=0; $i < $contador ; $i++) {
        if (buscarcategoria($codigos[$i],$categoria->valor_lista)) {

          $precio=$cantidades[$i]*validarprecio($codigos[$i],$cliente);
          $cantidadporcategoria=$cantidadporcategoria+$cantidades[$i];
          $total=$total+$precio;
          echo "<tr><td style='text-align:center'>".$cantidadporcategoria. "</td>";

          if ($cat==0) {
            echo "<td style='text-align:left'>".$categoria->valor_item. "</td>";
            $cat=1;
          }
        }
      }
      if ($cat==1) {
        echo "<td style='text-align:right'>$ ".number_format($total)."</td></tr>";
        $totalsuma=$totalsuma+$total;
      }
  }
  echo "<tr><th colspan='3' style='color:white'>.</th></tr>
  <tr><td></td><th style='text-align:left'>SUBTOTAL :</th><td style='text-align:right'>$ ".number_format($totalsuma)."</td></tr>";

  $conceptosdescuento=explode(',',$concepto_descuento);
  $descuentos=explode(',',$descuento);
  $contadordescuento=count($conceptosdescuento);
  $totaldescuentos=0;
  for ($i=0; $i < $contadordescuento ; $i++) {
        echo "<tr style='border-style: hidden'><td></td><th style='text-align:left'>".strtoupper($conceptosdescuento[$i]). " :</th>";
        echo "<td style='text-align:right'>- $ ".number_format($descuentos[$i])."</td></tr>";
        $totaldescuentos=$totaldescuentos+$descuentos[$i];
    }

    $conceptosimpuesto=explode(',',$concepto_impuesto);
    $impuesto=explode(',',$impuesto);
    $contadorimpuestos=count($conceptosimpuesto);
    $totalimpuesto=0;
    for ($i=0; $i < $contadorimpuestos ; $i++) {
          echo "<tr style='border-style: hidden'><td></td><th style='text-align:left'>".strtoupper($conceptosimpuesto[$i]). " :</th>";
          echo "<td style='text-align:right' > $ ".number_format($impuesto[$i])."</td></tr>";
        $totalimpuesto= $totalimpuesto+$impuesto[$i];
      }
       $final=$totalsuma-$totaldescuentos+$totalimpuesto;
        echo "<tr style='border-style: hidden'><td></td><th style='text-align:left'>TOTAL :</th><td style='text-align:right'>$ ".number_format($final)."</td></tr>";
}



function valorfactura($codigos,$cantidades,$cliente)
{
  $codigos=explode(',',$codigos);
  $cantidades=explode(',',$cantidades);
  $contador=count($codigos);
  $total=0;
      for ($i=0; $i < $contador ; $i++) {
          $total=$total+($cantidades[$i]*validarprecio($codigos[$i],$cliente));
      }
      return $total;
}

function buscar_descuentos($conceptos,$descuentos)
{
$conceptos=explode(',',$conceptos);
$descuentos=explode(',',$descuentos);
$contador=count($conceptos);
for ($i=0; $i < $contador; $i++) {
  echo "<tr>
  <td>".$conceptos[$i]."</td>
  <td style='color:red'>$ ".number_format($descuentos[$i])."</td>
  </tr>
";

}
}

function buscar_recargos($conceptos,$descuentos)
{
$conceptos=explode(',',$conceptos);
$descuentos=explode(',',$descuentos);
$contador=count($conceptos);
for ($i=0; $i < $contador; $i++) {
  echo "<tr>
  <td>".$conceptos[$i]."</td>
  <td style='color:green'>$ ".number_format($descuentos[$i])."</td>
  </tr>
";

}
}
