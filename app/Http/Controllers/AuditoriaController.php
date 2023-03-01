<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Auditoria;
use Illuminate\Support\Facades\DB;

class AuditoriaController extends Controller
{
    public function index()
    {
        return Auditoria::with('usuario')->orderBy('created_at')->paginate();
    }

    public function getTipos()
    {
        return TipoIncidencia::get(); 
    }

    public function search($search)
    {
        $auditorias = null;

        if(is_numeric($search)){
            $auditorias = Auditoria::with('usuario')
             ->where('usuarios_id', $search)
             ->orderBy('id','desc')
             ->paginate();
        }

        else{
             $auditorias = Auditoria::with('usuario')
             ->whereHas('usuario', function($q) use($search){
                $q->where('nombre','=','%'.$search.'%');
             })
             ->orWhere('descripcion','=','%'.$search.'%')
             ->orderBy('id','desc')
             ->paginate();
        }

        if( !$auditorias->isEmpty() ){
            return $auditorias;
        }else{
            return $this->index();
        }

        if($auditorias == null)
            return $this->index();
    }
}
