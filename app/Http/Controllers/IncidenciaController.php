<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Incidencia;
use App\TipoIncidencia;
use Illuminate\Support\Facades\DB;

class IncidenciaController extends Controller
{
    public function index()
    {
        return Incidencia::with('guardia.usuario','interseccion','tipo')->orderBy('created_at')->paginate();
    }

    public function getTipos()
    {
        return TipoIncidencia::get(); 
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'accion' => 'required',
            'descripcion' => 'sometimes',
            'observacion' => 'sometimes',
            'solucion' => 'sometimes',
            'tipo_incidencias_id' => 'sometimes',
            'guardias_id' => 'required',
            'intersecciones_id' => 'required'
        ]);

        try{
            DB::beginTransaction();
            $incidencia = Incidencia::create([
                'accion' => $request->accion,
                'descripcion' => $request->descripcion,
                'observacion' => $request->observacion,
                'solucion' => $request->solucion,
                'tipo_incidencias_id' => $request->tipo_incidencias_id,
                'guardias_id' => $request->guardias_id,
                'intersecciones_id' => $request->intersecciones_id,
                'usuario_id' => Auth::user()->id,
            ]);

            DB::commit();
            \Log::info('Se ha creado nueva incidencia '.$incidencia->descripcion);
            return ['exito' => true, 'code' => 200, 'id' => $incidencia->id,'msg' => 'Se ha registrado con exito'];

        }catch (\Exception $e) {
            DB::rollback();
            return ['exito' => false, 'code' => 500, 'msg' => 'Ha ocurrido un error: '.$e->getMessage()];
        }
    }

    public function search($search)
    {
        $incidencias = null;

        if(is_numeric($search)){
            $incidencias = Incidencia::with('guardia.usuario','interseccion','tipo')
             ->where('tipo_incidencias_id', $search)
             ->orderBy('id','desc')
             ->paginate();
        }

        else{
             $incidencias = Incidencia::with('guardia.usuario','interseccion','tipo')
             ->where('accion','ilike','%'.$search.'%')
             ->orderBy('id','desc')
             ->paginate();
        }

        if( !$incidencias->isEmpty() ){
            return $incidencias;
        }else{
            return $this->index();
        }

        if($incidencias == null)
            return $this->index();
    }
}
