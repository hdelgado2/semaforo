<?php

namespace App\Http\Controllers;
use App\TipoIncidencia;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class TipoIncidenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $tipos = TipoIncidencia::get();

        return $tipos;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'tipo' => 'required'
        ]);

        try {
            DB::beginTransaction();

            TipoIncidencia::create([
                'tipo' => $request->tipo,
            ]);

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollback();
        }

        $tipos = TipoIncidencia::orderBy('id')->get();

        return ['exito' => 200,'msg' => 'Se ha Registrado con exito', 'tipos' => $tipos];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    
        $tipo = TipoIncidencia::whereId($id)->first();
    
        return $tipo;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edittipo(Request $request)
    {
        #dd($request);
        $this->validate($request, [
            'tipo' => 'required',
        ]);

        try {
            DB::beginTransaction();

            TipoIncidencia::find($request->id)->update([
                'tipo' => $request->tipo,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            dd($e->getMessage());
        }

        
        return ['exito' => 200,'msg' => 'Se ha Registrado con exito'];
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $tipo = TipoIncidencia::find($id)->delete();
        $tipos = TipoIncidencia::orderBy('id')->get();

        return $tipos;


    }
}
