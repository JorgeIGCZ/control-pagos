<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AlumnoResource;
use App\Models\Alumnos;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AlumnoapiController extends Controller
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
            $grupo        = $request->input('grupo');
            $estatus      = $request->input('estatus');

            $alumnosQuery = Alumnos::get();
            $alumnosQuery = !is_null($id)      ? $alumnosQuery->where('Id',$id) : $alumnosQuery;
            $alumnosQuery = !is_null($plantel) ? $alumnosQuery->where('Plantel_id',$plantel) : $alumnosQuery;
            $alumnosQuery = !is_null($nivel) ? $alumnosQuery->where('Nivel_id',$nivel) : $alumnosQuery;
            $alumnosQuery = !is_null($licenciatura) ? $alumnosQuery->where('Licenciatura_id',$licenciatura) : $alumnosQuery;
            $alumnosQuery = !is_null($sistema) ? $alumnosQuery->where('Sistema_id',$sistema) : $alumnosQuery;
            $alumnosQuery = !is_null($grupo) ? $alumnosQuery->where('Sistema_id',$sistema) : $alumnosQuery;
            $alumnosQuery = !is_null($estatus) ? $alumnosQuery->where('Estatus',$estatus) : $alumnosQuery;


            $alumnos = AlumnoResource::collection($alumnosQuery);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message'=>$e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $alumnos,
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
