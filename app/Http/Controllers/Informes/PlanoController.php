<?php

namespace App\Http\Controllers\Informes;

use App\Http\Controllers\Controller;
use App\Models\Plano;
use App\Models\Informe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
class PlanoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        abort_if(Gate::denies('planos_index'),403);
        $datosUsuarios['planos'] = Plano::all();
        $informe = Informe::all();
        foreach($informe as $info)
        {
            if($id == $info->id)
            {
                if($info->nombreAgencia == "")
                {
                    $resul = $info->tipoInforme." ".$info->nombreAtm;
                }else
                {
                    $resul = $info->tipoInforme." ".$info->nombreAgencia;
                }
            }
        }
        return view('plano.index',$datosUsuarios,compact('id','resul'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        abort_if(Gate::denies('planos_create'),403);
        $informe = Informe::all();
        foreach($informe as $info)
        {
            if($id == $info->id)
            {
                if($info->nombreAgencia == "")
                {
                    $resul = $info->tipoInforme." ".$info->nombreAtm;
                }else
                {
                    $resul = $info->tipoInforme." ".$info->nombreAgencia;
                }
            }
        }
        return view('plano.create', compact('id','resul'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $campos=[
            'nombre'=>'required|string|max:1000000',
            'tipoPlano'=>'required|string|max:1000000'
        ];
        $mensaje =[
            'required'=>'El :attribute es requerido'
        ];
        $this->validate($request,$campos,$mensaje);      
        //$datosEmpleado = request()->all();
        $datosPlano = request()->except('_token');
        //Empleado::insert($datosEmpleado); 
        if($request-> hasFile('planta')){
            
            $file = $request->file('planta');
            $nombre = date("Y-m-d",time())."_".$file->getClientOriginalName();
            //$datosTrabajo['imagen']=$request->file('imagen')->store('uploads','public');
            $datosPlano['planta']=$file->storeAs('planos',$nombre,'public');
        }   
        Plano::insert($datosPlano);
        $post = request()->input('informe_id');
        return redirect('/planosAgencias/'.$post)->with('nuevo','ok');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plano  $plano
     * @return \Illuminate\Http\Response
     */
    public function show(Plano $plano)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plano  $plano
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('planos_edit'),403);
        $plano = Plano::findOrFail($id);
        $informe = Informe::all();
        foreach($informe as $info)
        {
            if($plano->informe_id == $info->id)
            {
                if($info->nombreAgencia == "")
                {
                    $resul = $info->tipoInforme." ".$info->nombreAtm;
                }else
                {
                    $resul = $info->tipoInforme." ".$info->nombreAgencia;
                }
            }
        }
        return view('plano.edit', compact('plano','resul'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plano  $plano
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $plano = Plano::findOrFail($id);
        $datosPlano = request()->except(['_token','_method','informe_id']);
        
        if($request-> hasFile('planta')){
            Storage::delete('public/'.$plano->planta);
            $file = $request->file('planta');
            $nombreImagen = date("Y-m-d",time())."_".$file->getClientOriginalName();
            //$datosTrabajo['imagen']=$request->file('imagen')->store('uploads','public');
            $datosPlano['planta']=$file->storeAs('planos',$nombreImagen,'public');
            //$datosTrabajo['imagen'] = $request->file('imagen')->store('trabajos','public');
        }
        
        Plano::where('id', '=' , $id)->update($datosPlano);
        $post = request()->input('informe_id');
        return redirect('/planosAgencias/'.$post)->with('actualizar','ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plano  $plano
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('planos_destroy'),403);
        $datosTrabajo = Plano::findOrFail($id);
        $idIn = $datosTrabajo->informe_id;
        Plano::destroy($id);
        return redirect('/planosAgencias/'.$idIn)->with('eliminar','ok');
    }
}
