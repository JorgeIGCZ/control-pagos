<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\LicenciaturaResource;
use App\Models\Licenciaturas;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\JsonResponse;

class LicenciaturaapiController extends Controller
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
            $nivel   = $request->input('nivel');
            $estatus = $request->input('estatus');

            $licenciaturasQuery = Licenciaturas::orderBy('Nombre', 'asc')->get();
            $licenciaturasQuery = !is_null($id)      ? $licenciaturasQuery->where('Id',$id) : $licenciaturasQuery;
            $licenciaturasQuery = !is_null($plantel) ? $licenciaturasQuery->where('Plantel_id',$plantel) : $licenciaturasQuery;
            $licenciaturasQuery = !is_null($nivel)   ? $licenciaturasQuery->where('Nivel_id',$plantel) : $licenciaturasQuery;
            $licenciaturasQuery = !is_null($estatus) ? $licenciaturasQuery->where('Estatus',$estatus) : $licenciaturasQuery;

            $licenciatura = LicenciaturaResource::collection($licenciaturasQuery);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message'=>$e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $licenciatura,
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
