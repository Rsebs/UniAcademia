<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return response()->json(Student::all());
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
     * @param  \App\Http\Requests\StudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
        try {
            $student = Student::create($request->input());
            
            return response()->json([
                "data" => $student,
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
            $student = Student::find($id);
            if ($student) {
                return response()->json([
                    "data" => $student,
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
        $student = Student::find($id);

        if ($student) {
            $validator = Validator::make($request->all(), [
                "document" => "required|string|max:10|unique:students,document,$student->id",
                "names" => "required|string",
                "phone" => "required|string|max:10",
                "email" => "required|string|unique:students,email,$student->id",
                "address" => "required|string",
                "semester" => "required|integer|min:1|max:9",
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
        $student = Student::find($id);
        if ($student) {
            try {
                $student->delete();

                return response()->json([
                    "data" => $student,
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
