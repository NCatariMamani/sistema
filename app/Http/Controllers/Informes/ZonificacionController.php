<?php

namespace App\Http\Controllers\Informes;

use App\Http\Controllers\Controller;
use App\Models\Zonificacion;
use App\Models\Informe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ZonificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        abort_if(Gate::denies('zonificaciones_index'), 403);
        $datosZona['zonas'] = Zonificacion::all();
        $informe = Informe::all();
        foreach ($informe as $info) {
            if ($id == $info->id) {
                if ($info->nombreAgencia == "") {
                    $resul = $info->tipoInforme . " " . $info->nombreAtm;
                } else {
                    $resul = $info->tipoInforme . " " . $info->nombreAgencia;
                }
            }
        }
        return view('zonificacion.index', $datosZona, compact('id', 'resul'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        abort_if(Gate::denies('zonificaciones_create'), 403);
        $informe = Informe::all();
        foreach ($informe as $info) {
            if ($id == $info->id) {
                if ($info->nombreAgencia == "") {
                    $resul = $info->tipoInforme . " " . $info->nombreAtm;
                } else {
                    $resul = $info->tipoInforme . " " . $info->nombreAgencia;
                }
            }
        }
        return view('zonificacion.create', compact('id','resul'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $campos = [
            'nombreModulo' => 'required|string|max:100',
            'numeroSerie' => 'required|string|max:100',
            'numeroZona' => 'required|integer|max:100',
            'numeroParticion' => 'required|integer|max:100',
            'nombreParticion' => 'required|string|max:100',
            'descripcion' => 'required|string'
        ];
        $mensaje = [
            'required' => 'El :attribute es requerido'
        ];

        $this->validate($request, $campos, $mensaje);

        //$datosEmpleado = request()->all();
        $datosZona = request()->except('_token');
        //Empleado::insert($datosEmpleado);

        Zonificacion::insert($datosZona);
        $post = request()->input('informe_id');
        return redirect('/zonas/' . $post)->with('nuevo', 'ok');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Zonificacion  $zonificacion
     * @return \Illuminate\Http\Response
     */
    public function show(Zonificacion $zonificacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Zonificacion  $zonificacion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('zonificaciones_edit'), 403);
        $zona = Zonificacion::findOrFail($id);
        $informe = Informe::all();
        foreach ($informe as $info) {
            if ($zona->informe_id == $info->id) {
                if ($info->nombreAgencia == "") {
                    $resul = $info->tipoInforme . " " . $info->nombreAtm;
                } else {
                    $resul = $info->tipoInforme . " " . $info->nombreAgencia;
                }
            }
        }
        return view('zonificacion.edit', compact('zona','resul'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Zonificacion  $zonificacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $datosZona = request()->except(['_token', '_method', 'informe_id']);
        Zonificacion::where('id', '=', $id)->update($datosZona);
        $post = request()->input('informe_id');
        return redirect('/zonas/' . $post)->with('actualizar', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Zonificacion  $zonificacion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('zonificaciones_destroy'), 403);
        $datosZona = Zonificacion::findOrFail($id);
        $idIn = $datosZona->informe_id;
        Zonificacion::destroy($id);
        return redirect('/zonas/' . $idIn)->with('eliminar', 'ok');
    }
}
