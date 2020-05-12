<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'dni', 'address', 'phone', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','pivot',
        "created_at","updated_at"
    ];

    public static $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];

    public static function createPatient(array $data){
        return self::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 'patient'
        ]);
    }

    public function scopePatients($query)
    {
        return $query->where('role', 'patient');
    }
    public function scopeDoctors($query)
    {
        return $query->where('role', 'doctor');
    }

    public function specialties()
    {
        return $this->belongsToMany(Specialty::class)->withTimeStamps();

    }

    // $user->asPatientAppointments
    // $user->asDoctorAppointments
    public function asDoctorAppointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public function attendedAppointments()
    {
        return $this->asDoctorAppointments()->where('status', 'Atendida');
    }

     public function cancelledAppointments()
    {
        return $this->asDoctorAppointments()->where('status', 'Cancelada');
    }

     public function asPatientAppointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }


}
