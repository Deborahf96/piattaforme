<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ResettaPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function resetta_password_view()
    {
        $user = Auth::user();
        return view('resetta_password.resetta')->with(['user' => $user]);
    }

    public function cambia_password(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $this->valida_password($request);
        $user->update([
            'password' => Hash::make($request->input('password')),
        ]);
        return redirect('/')->with('success', "Password modificata");
    }

    private function valida_password($request)
    {
        $rules = [
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required'
        ];
        
        $customMessages = [
            'password.required' => "E' necessario inserire una password",
            'password.min' => "La password deve avere minimo 8 caratteri",
            'password.confirmed' => "Le password inserite non coincidono",
            'password_confirmation.required' => "E' necessario inserire la password anche nel campo 'Ripeti password'",
        ];

        $this->validate($request, $rules, $customMessages);
    }
}
