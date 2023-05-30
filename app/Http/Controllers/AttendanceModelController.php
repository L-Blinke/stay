<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\AttendanceModel;
use App\Models\TokenModel;
use Illuminate\Support\Facades\Auth;

class AttendanceModelController extends Controller
{
    /**
     * Mostrar el formulario para crear una nueva asistencia.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('attendance.create');
    }

    /**
     * Almacenar una nueva asistencia en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->privilege->privilege_grade == 2 || Auth::user()->privilege->privilege_grade == 3) {
            // Crear una nueva instancia de AttendanceModel y asignar los valores
            if ((AttendanceModel::where('student_id', '=', TokenModel::where('token', '=', $request->_token)->first()->student_id)->exists())) {
                if ((AttendanceModel::where('student_id', '=', TokenModel::where('token', '=', $request->_token)->first()->student_id)->orderBy('created_at', 'desc')->first())->created_at->day !== date('d')) {
                    $token = TokenModel::where('token','=', $request->_token)->first();

                    $attendance = new AttendanceModel;
                    $attendance->student_id = $token->student_id;

                    // Guardar la asistencia en la base de datos
                    $attendance->save();
                    $token->delete();
                }else{
                    return abort(404);
                }
            }else {
                $token = TokenModel::where('token','=', $request->_token)->first();

                $attendance = new AttendanceModel;
                $attendance->student_id = $token->student_id;

                // Guardar la asistencia en la base de datos
                $attendance->save();
                $token->delete();
            }
        }else{
            return abort(404);
        }
    }

    /**
     * Eliminar una asistencia específica de la base de datos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Buscar la asistencia por ID y eliminarla
        $attendance = AttendanceModel::find($id);
        $attendance->delete();
    }
}
