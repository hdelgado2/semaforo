<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Guardia;

class GuardiaController extends Controller
{
    public function index()
    {
        return Guardia::paginate();
    }

    public function getGuardias()
    {
        return Guardia::get(); 
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
        $guardias = null;

        if(is_numeric($search)){
            $auditorias = Guardia::with('usuario')
             ->where('usuarios_id', $search)
             ->orderBy('id','desc')
             ->paginate();
        }

        else{
             $guardias = Guardia::with('usuario')
             ->whereHas('usuario', function($q) use($search){
                $q->where('nombre','=','%'.$search.'%');
             })
             ->orWhere('descripcion','=','%'.$search.'%')
             ->orderBy('id','desc')
             ->paginate();
        }

        if( !$guardias->isEmpty() ){
            return $guardias;
        }else{
            return $this->index();
        }

        if($guardias == null)
            return $this->index();
    }
}
