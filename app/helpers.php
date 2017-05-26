<?php
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
