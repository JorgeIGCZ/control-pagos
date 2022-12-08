<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\NivelResource;
use App\Models\Niveles;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\JsonResponse;

class NivelapiController extends Controller
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
     * @param  $plantel
     * @return \Illuminate\Http\Response
     */
    public function busqueda(Request $request){
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
            $id      = $request->input('id');
            $plantel = $request->input('plantel');
            $estatus = $request->input('estatus');

            $nivelesQuery = Niveles::orderBy('Nombre', 'desc')->get();
            $nivelesQuery = !is_null($id)      ? $nivelesQuery->where('Id',$id) : $nivelesQuery;
            $nivelesQuery = !is_null($plantel) ? $nivelesQuery->where('Plantel_id',$plantel) : $nivelesQuery;
            $nivelesQuery = !is_null($estatus) ? $nivelesQuery->where('Estatus',$estatus) : $nivelesQuery;

            $niveles = NivelResource::collection($nivelesQuery);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message'=>$e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $niveles,
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
