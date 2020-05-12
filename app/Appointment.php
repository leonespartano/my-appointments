<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Http\Request;
class Appointment extends Model
{
    protected $fillable = [
        'description',
        'specialty_id',
        'doctor_id',
        'patient_id',
        'scheduled_date',
        'scheduled_time',
        'type'
    ];

    //Se genero la propiedad protected en la tema de api y android
    protected $hidden = [
        'specialty_id',
        'doctor_id',
        'scheduled_time',
    ];
    //Se genero la propiedad protected en la tema de api y android
    //appends se emplea para mostrar la hora en formato de 12 horas
    protected $appends = [
        'scheduled_time_12',
    ];



    //N Permite seleccionar una especialidad desde una cita. 1
    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }
    //N appoinment->doctor 1
    public function doctor()
    {
        return $this->belongsTo(User::class);
    }
    //N appoinment->patient 1
    public function patient()
    {
        return $this->belongsTo(User::class);
    }
    // 1 appointment - 1 cancelled-appointment
    // $appointment->cancellation->justification
    public function cancellation()
    {
        return $this->hasOne(CancelledAppointment::class);
    }

    //Accesor
    //Converción automatica de fechas. De string a Carbon.
    //En la vista se observa $appointment->scheduled_time_12
    public function getScheduledTime12Attribute()
    {
        return (new Carbon($this->scheduled_time))->format('g:i A');
    }

    static public function createForPatient(Request $request, $patientId){
         $data = $request->only([
            'description',
            'specialty_id',
            'doctor_id',
            'scheduled_date',
            'scheduled_time',
            'type'
        ]);
        //Es el id del usuario que esta ingresando.
        $data['patient_id'] = $patientId;
        $carbonTime = Carbon::createFromFormat('g:i A', $data['scheduled_time']);
        $data['scheduled_time'] = $carbonTime->format('H:i:s');

        return self::create($data);

    }
}
