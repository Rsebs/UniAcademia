<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfessorRequest;
use App\Models\Professor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return response()->json(Professor::all());
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
     * @param  \App\Http\Requests\ProfessorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProfessorRequest $request)
    {
        try {
            $professor = Professor::create($request->input());
            
            return response()->json([
                "data" => $professor,
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
            $professor = Professor::find($id);
            if ($professor) {
                return response()->json([
                    "data" => $professor,
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
        $student = Professor::find($id);

        if ($student) {
            $validator = Validator::make($request->all(), [
                "document" => "required|string|max:10|unique:professors,document,$student->id",
                "names" => "required|string",
                "phone" => "required|string|max:10",
                "email" => "required|string|unique:professors,email,$student->id",
                "address" => "required|string",
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    "msg" => "La validación falló",
                    "errors"  => $validator->errors(),
                ], 422);
            }

            try {
                $student->update($request->input());

                return response()->json([
                    "data" => $student,
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
        $professor = Professor::find($id);
        if ($professor) {
            try {
                $professor->delete();

                return response()->json([
                    "data" => $professor,
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
