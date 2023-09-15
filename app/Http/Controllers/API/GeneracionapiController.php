<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\GeneracionResource;
use App\Models\Generaciones;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\JsonResponse;

class GeneracionapiController extends Controller
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
            $id      = $request->input('id');
            $plantel = $request->input('plantel');
            $estatus = $request->input('estatus');

            $geneacionesQuery = Generaciones::orderBy('Nombre', 'asc')->get();
            $geneacionesQuery = (!is_null($id))     ? $geneacionesQuery->where('Id',$id) : $geneacionesQuery;
            $geneacionesQuery = (!is_null($plantel)) ? $geneacionesQuery->where('Plantel_id',$plantel) : $geneacionesQuery;
            $geneacionesQuery = (!is_null($estatus)) ? $geneacionesQuery->where('Estatus',$estatus) : $geneacionesQuery;

            $generacion = GeneracionResource::collection($geneacionesQuery);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message'=>$e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $generacion,
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
