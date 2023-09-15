<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AlumnoResource;
use App\Models\Alumnos;
use Exception;
use Illuminate\Database\Eloquent\Builder;
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
            $lista        = $request->input('lista');

            $alumnosQuery = Alumnos::whereHas('alumnoRelaciones', function (Builder $subquery) use ($id, $plantel, $nivel, $licenciatura, $sistema, $grupo, $estatus, $lista) { 
                if(!is_null($id)){
                    $subquery->where('Id', $id);
                }
                if(!is_null($plantel)){
                    $subquery->where('Plantel_id', $plantel);
                }
                if(!is_null($nivel)){
                    $subquery->where('Nivel_id', $nivel);
                }
                if(!is_null($licenciatura)){
                    $subquery->where('Licenciatura_id', $licenciatura);
                }
                if(!is_null($sistema)){
                    $subquery->where('Sistema_id', $sistema);
                }
                if(!is_null($grupo)){
                    $subquery->where('Grupo_id', $grupo);
                }
                if(!is_null($estatus)){
                    $subquery->where('Estatus', $estatus);
                }
                if(!is_null($lista)){
                    $subquery->where('Id', $lista);
                }
            })->orderBy('Nombre', 'asc')->get();

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
