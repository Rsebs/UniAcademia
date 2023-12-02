<?php

namespace App\Http\Controllers;

use App\Http\Requests\Knowledge_areaRequest;
use App\Models\Knowledge_area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Knowledge_areaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return response()->json(Knowledge_area::all());
        } catch (\Exception $e) {
            return response()->json([
                "msg" => "Algo salió mal.",
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Knowledge_areaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Knowledge_areaRequest $request)
    {
        try {
            $knowledge_area = Knowledge_area::create($request->input());
            
            return response()->json([
                "data" => $knowledge_area,
                "msg" => "Registro guardado.",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "msg" => "Algo salió mal.",
                "error" => $e->getMessage(),
            ], 500);
        }
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
            $knowledge_area = Knowledge_area::find($id);
            if ($knowledge_area) {
                return response()->json([
                    "data" => $knowledge_area,
                    "msg" => "Registro encontrado.",
                ]);
            }

            return response()->json([
                "msg" => "Registro no encontrado.",
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                "msg" => "Algo salió mal",
                "error" => $e->getMessage(),
            ], 500);
        }
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

        $knowledge_area = Knowledge_area::find($id);

        if ($knowledge_area) {
            $validator = Validator::make($request->all(), [
                "name" => "required|string|unique:knowledge_areas,name,$knowledge_area->id",
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    "msg" => "La validación falló",
                    "errors"  => $validator->errors(),
                ], 422);
            }

            try {
                $knowledge_area->update($request->input());

                return response()->json([
                    "data" => $knowledge_area,
                    "msg" => "Registro actualizado.",
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    "msg" => "Algo salió mal.",
                    "error" => $e->getMessage(),
                ], 500);
            }
        }

        return response()->json([
            "msg" => "El registro no existe.",
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $knowledge_area = Knowledge_area::find($id);
        if ($knowledge_area) {
            try {
                $knowledge_area->delete();

                return response()->json([
                    "data" => $knowledge_area,
                    "msg" => "Registro eliminado.",
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    "msg" => "Algo salió mal.",
                    "error" => $e->getMessage(),
                ], 500);
            }
        }

        return response()->json([
            "msg" => "El registro no existe.",
        ], 404);
    }
}
