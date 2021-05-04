<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ForgotPassword extends Controller
{
    public function forgot(){
        return view('auth.forgot');
    }

    public function password(Request $request){
        dd($request->all());
    }
}
