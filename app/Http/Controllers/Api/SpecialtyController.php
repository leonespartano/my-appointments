<?php

namespace App\Http\Controllers\Api;

use App\Specialty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpecialtyController extends Controller
{
    public function index()
    {
        //Devuelve un JSON una colección. Laravel.
        return Specialty::all(['id','name']);
    }

    public function doctors(Specialty $specialty)
    {
        //Devuelve un JSON una colección. Laravel.
        return $specialty->users()->get([
            'users.id', 'users.name'
            ]);
    }
}
