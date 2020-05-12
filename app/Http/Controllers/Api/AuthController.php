<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use JwtAuth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Http\Traits\ValidateAndCreatePatient;



class AuthController extends Controller
{
    use ValidateAndCreatePatient;
    public function login(Request $request){

        $credentials = $request -> only('email','password');


        if(Auth::guard('api')->attempt($credentials)) {
            $user = Auth::guard('api')->user();
            $jwt = JwtAuth::generateToken($user);

            $success = true;

            return \compact('success', 'user', 'jwt');

            // Return successfull sign in response with the generated jwt.
        } else {
            // Return response for failed attempt...
            $success = false;
            $message = 'Invalid credentials';
            return \compact('success','message');
        }
    }



    public function logOut(){
        Auth::guard('api')->logout();
        $success = true;
        return \compact('success');
    }

    public function register(Request $request){
         $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        Auth::guard('api')->login($user);

        $jwt = JwtAuth::generateToken($user);

            $success = true;

            return \compact('success', 'user', 'jwt');
    }


}
