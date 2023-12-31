<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\retirement;
use App\Models\TokenModel;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DateController;

class RetirementQr extends Component
{
    public string $qrlink;

    public $lasttoken; //TokenModel

    public bool $alreadylogedin;
    public bool $attendance;

    /**
     * Almacenar una nueva asistencia en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $student_id = Auth::user()->id;

        // Crear una nueva instancia de TokenModel y asignar los valores
        $token = new TokenModel;
        $token->student_id = $student_id;
        $token->token = csrf_token();
        // Asigna aquí los demás campos de la tabla

        // Generar link del codigo qr
        $this->qrlink = "http://localhost:8000/retirement/".$token->token;
        // Guardar la asistencia en la base de datos
        $token->save();

        $token = $this->lasttoken;

        $token = null;
    }

    public function generate()
    {
        if (retirement::where('student_id', '=', Auth::user()->id)->orderBy('created_at', 'desc')->exists()) {
            if ((retirement::where('student_id', '=', Auth::user()->id)->orderBy('created_at', 'desc')->first())->created_at->day !== (int)date('d')) {
                $this->alreadylogedin = false;

                $this->create();

                if ($this->lasttoken) {
                    $this->lasttoken->delete();
                }
            }else{
                $this->alreadylogedin = true;
            }
        }else{
            $this->alreadylogedin = false;

            $this->create();

            if ($this->lasttoken) {
                $this->lasttoken->delete();
            }
        }
    }

    public function render()
    {
        if(Auth::user()->privilege->privilege_grade == 1){
            $dateController = new DateController(Auth::user()->currentTeam);

            if ($dateController->estadoDelDia(Auth::user()->id) !== 4 ) {
                $this->attendance = true;
            }else{
                $this->attendance = false;
            }
        }

        return view('livewire.retirement-qr');
    }
}
