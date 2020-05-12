<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Interfaces\ScheduleServiceInterface;
use App\Http\Requests\StoreAppointment;
use Illuminate\Http\Request;
use App\CancelledAppointment;
use App\Specialty;
use Carbon\Carbon;
use Validator;


class AppointmentController extends Controller
{
    public function index ()
    {
        $role = \auth()->user()->role;
        if ($role == 'admin'){
            $pendingAppointments = Appointment::where('status', 'Reservada')
                ->paginate(10);
            $confirmedAppointments = Appointment::where('status', 'Confirmada')
                ->paginate(10);
            $oldAppointments = Appointment::whereIn('status', ['Confirmada', 'Cancelada'])
                ->paginate(10);
        }elseif ($role == 'doctor'){
            $pendingAppointments = Appointment::where('status', 'Reservada')
            ->where('doctor_id', \auth()->id())
            ->paginate(10);
            $confirmedAppointments = Appointment::where('status', 'Confirmada')
            ->where('doctor_id', \auth()->id())
            ->paginate(10);
            $oldAppointments = Appointment::whereIn('status', ['Confirmada', 'Cancelada'])
            ->where('doctor_id', \auth()->id())
            ->paginate(10);

        }elseif ($role == 'patient'){
            $pendingAppointments = Appointment::where('status', 'Reservada')
            ->where('patient_id', \auth()->id())
            ->paginate(10);
            $confirmedAppointments = Appointment::where('status', 'Confirmada')
            ->where('patient_id', \auth()->id())
            ->paginate(10);
            $oldAppointments = Appointment::whereIn('status', ['Confirmada', 'Cancelada'])
            ->where('patient_id', \auth()->id())
            ->paginate(10);
        }


        return view('appointments.index', compact('pendingAppointments',
            'confirmedAppointments', 'oldAppointments', 'role'));
    }

    public function show(Appointment $appointment)
    {
        $role = \auth()->user()->role;
        return view('appointments.show', compact('appointment', 'role'));
    }


    public function create(ScheduleServiceInterface $scheduleService)
    {
        $specialties = Specialty::all();

        $specialtyId = old('specialty_id');
        if ($specialtyId) {
            $specialty = Specialty::find($specialtyId);
            $doctors = $specialty->users;
        } else {
            $doctors = \collect();
        }

        $Date = old('scheduled_date');
        $doctorId = old('doctor_id');
        if ($Date && $doctorId) {
            $intervals = $scheduleService->getAvailableIntervals($Date, $doctorId);
        } else {
            $intervals = null;
        }

        return view('appointments.create', \compact('specialties', 'doctors', 'intervals'));
    }

    //Se realiza un form request empleando la clase StoreAppointments
    public function store(StoreAppointment $request)
    {
        //En la version de android se elimino $rules y $messages

        /*
        $validator->after(function ($validator) use ($request, $scheduleService) {

        });

        if ($validator->fails()) {
            return \back()
                ->withErrors($validator)
                ->withInput();
        }


        */

        $created = Appointment::createForPatient($request, \auth()->id());

        if ($created)
            $notification = 'La cita se ha registrado correctamente';
        else
            $notification = 'Ocurrio un problema al registrar la cita médica';

        return back()->with(\compact('notification'));
    }

    public function showCancelForm(Appointment $appointment)
    {
        if ($appointment->status == 'Confirmada'){
            $role = auth()->user()->role;
            return view('appointments.cancel', compact('appointment', 'role'));
        }else{
            return redirec('/appointments');
        }
    }

    public function postCancel(Appointment $appointment, Request $request)
    {
        if ($request->has('justification')){
            $cancellation = new CancelledAppointment();
            $cancellation->justification = $request->input('justification');
            $cancellation->cancelled_by = auth()->id();

            //$cancellation -> appointment_id = ;
            //$cancellation->save()
            $appointment->cancellation()->save($cancellation);
        }
        $appointment->status ='Cancelada';
        $appointment->save();//Update

        $notification = 'La cita se ha cancelado correctamente.';
        return redirect('/appointments')->with(compact('notification'));
    }
    public function postConfirm(Appointment $appointment)
    {

        $appointment->status ='Confirmada';
        $appointment->save();//Update

        $notification = 'La cita se ha confirmado correctamente.';
        return redirect('/appointments')->with(compact('notification'));
    }

}
