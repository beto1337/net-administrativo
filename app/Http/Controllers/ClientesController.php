<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use View;
use DB;
use Auth;

class ClientesController extends Controller
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


  public function registrarcliente()
  {
    $clase=DB::table('app_listas')->where('id_tipo_lista',5)->get();
    $tipos=DB::table('app_listas')->where('id_tipo_lista',3)->get();
    $clientes=DB::table('app_clientes')->get();
    return View::make("clientes.registrarcliente")->with(array('clientes'=>$clientes,'tipos'=>$tipos,'clase'=>$clase));
  }
  public function crearcliente(Request $request)
  {
  $clase=$request->clase;
  if ($clase==1) {
    $this->validate($request, [
      'nombre' => 'required',
      'nit' => 'required|numeric|unique:app_clientes,nit',
      'telefono' => 'required|numeric|unique:app_clientes,telefono',
      'celular'=>'required|numeric|unique:app_clientes,celular',
      'correo' => 'required|email|unique:app_clientes,correo',
      'direccion' => 'required',
    ]);
    $nit=$request->nit;
    $apellido='';
    $cedula='';
  }else {
    $this->validate($request, [
      'nombre' => 'required',
      'apellido' => 'required',
      'cedula' => 'required|numeric|unique:app_clientes,cedula',
      'telefono' => 'required|numeric|unique:app_clientes,telefono',
      'celular'=>'required|numeric|unique:app_clientes,celular',
      'correo' => 'required|email|unique:app_clientes,correo',
      'direccion' => 'required',
    ]);
        $nit='';
        $cedula=$request->cedula;
        $apellido=$request->apellido;
  }
  DB::table('app_clientes')->insert([['nombre'=>strtoupper($request->nombre),'apellido'=>strtoupper($apellido),
  'clase'=>$request->clase,'nit'=>$nit,'cedula'=>$cedula,'telefono'=>$request->telefono,'celular'=>$request->celular,
  'correo'=>$request->correo,'direccion'=>$request->direccion,'tipo'=>$request->tipo]]);

  $idf=DB::table('app_clientes')->max('id');
  return redirect('clientes');
  }

  public function buscarcliente()
  {
    $tipos=DB::table('app_listas')->where('id_tipo_lista',3)->get();
    $clientes=DB::table('app_clientes')->get();
    return View::make("clientes.buscar")->with(array('clientes'=>$clientes,'tipos'=>$tipos));
  }
  public function editarcliente($id)
  {
    $clase=DB::table('app_listas')->where('id_tipo_lista',5)->get();
    $tipos=DB::table('app_listas')->where('id_tipo_lista',3)->get();
    $clientes=DB::table('app_clientes')->where('id',$id)->get();
    return View::make("clientes.editar")->with(array('cliente'=>$clientes,'tipos'=>$tipos,'clase'=>$clase));
  }
  public function actualizarcliente(Request $request)
  {
    $id=$request->id;
    $clase=$request->clase;
    if ($clase==1) {
      $this->validate($request, [
        'nombre' => 'required',
        'nit' => 'required|numeric',
        'telefono' => 'required|numeric',
        'celular'=>'required|numeric',
        'correo' => 'required|email',
        'direccion' => 'required',
      ]);
      $nit=$request->nit;
      $apellido='';
      $cedula='';
    }else {
      $this->validate($request, [
        'nombre' => 'required',
        'apellido' => 'required',
        'cedula' => 'required|numeric',
        'telefono' => 'required|numeric',
        'celular'=>'required|numeric',
        'correo' => 'required|email',
        'direccion' => 'required',
      ]);
          $nit='';
          $cedula=$request->cedula;
          $apellido=$request->apellido;
    }
    DB::table('app_clientes')->where('id',$id)->update(['nombre'=>strtoupper($request->nombre),'apellido'=>strtoupper($apellido),
    'clase'=>$request->clase,'nit'=>$nit,'cedula'=>$cedula,'telefono'=>$request->telefono,'celular'=>$request->celular,
    'correo'=>$request->correo,'direccion'=>$request->direccion,'tipo'=>$request->tipo]);

    return redirect('clientes');




  }

}
