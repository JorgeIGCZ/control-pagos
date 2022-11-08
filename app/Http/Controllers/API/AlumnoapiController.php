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
        try {
            $alumnos = AlumnoResource::collection(Alumnos::all());
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
     * Store a newly created resource in storage.
     *
     * @param  $plantel
     * @param  $nivel
     * @param  $licenciatura
     * @param  $sistema
     * @param  $grupo
     * @param  $generacion
     * @return \Illuminate\Http\Response
     */
    public function busqueda($plantel,$nivel,$licenciatura,$sistema,$grupo,$generacion,$estatus){
        try {
            $niveles = AlumnoResource::collection(
                Alumnos::whereHas('alumnoRelaciones', function ($query) use ($plantel,$nivel,$licenciatura,$sistema,$grupo,$generacion) {
                    $query
                        ->where('Plantel_id',$plantel)
                        ->where('Nivel_id',$nivel)
                        ->where('Licenciatura_id',$licenciatura)
                        ->where('Sistema_id',$sistema)
                        ->where('Grupo_id',$grupo)
                        ->where('Generacion_id',$generacion);
                })->where('Estatus',$estatus)->get()
            );
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $generacion = AlumnoResource::collection(Alumnos::where('Id',$id)->get());
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
