<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\GrupoResource;
use App\Models\Grupos;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\JsonResponse;

class GrupoapiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            $id           = $request->input('id');
            $plantel      = $request->input('plantel');
            $nivel        = $request->input('nivel');
            $licenciatura = $request->input('licenciatura');
            $sistema      = $request->input('sistema');
            $estatus      = $request->input('estatus');

            $gruposQuery = Grupos::orderBy('Nombre', 'asc')->get();
            $gruposQuery = !is_null($id)      ? $gruposQuery->where('Id',$id) : $gruposQuery;
            $gruposQuery = !is_null($plantel) ? $gruposQuery->where('Plantel_id',$plantel) : $gruposQuery;
            $gruposQuery = !is_null($nivel) ? $gruposQuery->where('Nivel_id',$nivel) : $gruposQuery;
            $gruposQuery = !is_null($licenciatura) ? $gruposQuery->where('Licenciatura_id',$licenciatura) : $gruposQuery;
            $gruposQuery = !is_null($sistema) ? $gruposQuery->where('Sistema_id',$sistema) : $gruposQuery;
            $gruposQuery = !is_null($estatus) ? $gruposQuery->where('Estatus',$estatus) : $gruposQuery;

            $grupos = GrupoResource::collection($gruposQuery);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message'=>$e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $grupos,
            'message' => 'Succeed'
        ], JsonResponse::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
    }
}
