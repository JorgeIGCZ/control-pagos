<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PeriodoResource;
use App\Models\Generacion_periodos;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\JsonResponse;

class PeriodoapiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
            $generacion = $request->input('generacion');
            $estatus = $request->input('estatus');

            $periodosQuery = Generacion_periodos::orderBy('Periodo_numero', 'desc')->get();
            $periodosQuery = !is_null($id)         ? $periodosQuery->where('Id',$id) : $periodosQuery;
            $periodosQuery = !is_null($generacion) ? $periodosQuery->where('Generacion_id',$generacion) : $periodosQuery;
            $periodosQuery = !is_null($estatus)    ? $periodosQuery->where('Estatus',$estatus) : $periodosQuery;

            $periodo = PeriodoResource::collection($periodosQuery);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message'=>$e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $periodo,
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
