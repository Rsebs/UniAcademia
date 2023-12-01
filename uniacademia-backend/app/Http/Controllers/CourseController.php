<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return response()->json(Course::all());
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string|unique:courses",
            "description" => "required|string",
            "credits" => "required|integer|min:1|max:9",
            "knowledge_area_id" => "required|integer|min:1",
            "elective" => "required|bool",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "msg" => "Error en la validación.",
                "errors" => $validator->errors(),
            ]);
        }

        try {
            $course = Course::create($request->input());

            return response()->json([
                "data" => $course,
                "msg" => "Registro guardado.",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "msg" => "Algo salió mal.",
                'error' => $e->getMessage(),
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
            $course = Course::find($id);
            if ($course) {
                return response()->json([
                    "data" => $course,
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
        $course = Course::find($id);

        if ($course) {
            $validator = Validator::make($request->all(), [
                "name" => "required|string|unique:courses,name,$course->id",
                "description" => "required|string",
                "credits" => "required|integer|min:1|max:9",
                "knowledge_area_id" => "required|integer|min:1",
                "elective" => "required|bool",
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "msg" => "Error en la validación.",
                    "errors" => $validator->errors(),
                ]);
            }

            try {
                $course->update($request->input());

                return response()->json([
                    "data" => $course,
                    "msg" => "Registro actualizado.",
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    "msg" => "Algo salió mal.",
                    "error" => $e->getMessage(),
                ], 500);
            }
        } else {
            return response()->json([
                "msg" => "El registro no existe.",
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::find($id);
        if ($course) {
            try {
                $course->delete();

                return response()->json([
                    "data" => $course,
                    "msg" => "Registro eliminado.",
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    "data" => $course,
                    "msg" => "No se pudo eliminar: " . $e->getMessage(),
                ], 500);
            }
        }

        return response()->json([
            "msg" => "El registro no existe.",
        ], 404);
    }
}
