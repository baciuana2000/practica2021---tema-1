<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinal;
use Reminder;
use Mail;
use App\Models\User;

class ForgotPassword extends Controller
{
    public function forgot(){
        return view('auth.forgot');
    }

    public function password(Request $request){
       $user = User::whereEmail($request->email)->first();

       if($user == null)
       {
           return redirect()->back()->with(['error'=>'Email not exists']);
       }

       $user = Sentinel::findById($user->id);
       $reminder = Reminder::exists($user) ? : Reminder::create($user);
       $this->sendEmail($user, $reminder->code);
       return redirect()->back()->with(['succes'=>'Reset code sent to your email']);

    }

    public function sendEmail($user , $code){
        Mail::send(
            'email.forgot',
            ['user' => $user , 'code' => $code],
            function($message) use ($user){
                $message->to($user->email);
                $message->subject("$user->name, reset your password.");
            }
        );
    }
}
