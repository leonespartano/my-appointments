<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointment;
use Auth;
use App\Appointment;

class AppointmentController extends Controller
{
    public function index(){
        /*
        "id",
        "description",
        "specialty_id",
        "doctor_id",
        "patient_id",
        "scheduled_date",
        "scheduled_time",
        "type",
        "created_at",
        "updated_at",
        "status"
        */
        $user = Auth::guard('api')->user();
        //with se especifica que relaciones nos interesa con modelo Appointment
        //se emplean funciones anonimas para hacer asociaciones
        //para realizar la query emplea specialty_id y doctor_id
        $appointments = $user->asPatientAppointments()
            ->with(['specialty' => function($query){
                $query->select('id', 'name');
            },
            'doctor' => function($query){
                 $query->select('id','name');
            }
            ])
            ->get([
                "id",
                "description",
                "specialty_id",
                "doctor_id",
                "scheduled_date",
                "scheduled_time",
                "type",
                "created_at",
                "status"
        ]);
        return $appointments;
    }

    public function store(StoreAppointment $request){
        $patientId = Auth::guard('api')->id();
        $appointment = Appointment::createForPatient($request, $patientId);
        if($appointment)
            $success = true;
        else
            $success = false;


        return compact('success');
    }

}
