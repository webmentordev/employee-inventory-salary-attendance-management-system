<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginWireController extends Controller
{
    public function store(Request $request){

        $this->validate($request,[
            'email' => 'required|email',
            'password'=> 'required|min:5'
        ]);
    
        if(!auth()->attempt($request->only(['email', 'password']), $request->remember)){
            return back()->with("failed", "The provided credentials are incorrect.");
        }

        return redirect()->route('user-attendance');
    }

    public function logout(Request $request){

        Auth::logout();

        return redirect()->route('home');
    }
}
