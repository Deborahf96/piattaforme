<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
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
        return view('resetta_password.resetta')->with(['user' => Auth::user()]);
    }

    public function cambia_password(Request $request)
    {
        try{
            $user = User::find($request->id);
            if(Hash::check($request->password_corrente, $user->password) && $request->password == $request->password_confirm){
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }
            else{
                if(!Hash::check($request->password_corrente, $user->password))
                    return back()->with('warningPassword', 'Errore! Password corrente non corretta.');
                else if($request->password != $request->password_confirm)
                    return back()->with('warningPassword', 'Errore! La nuova password non coincide con quella confermata.');
                else 
                    return back()->with('warningPassword', 'Errore! Password errata.');
            }
        } catch(Exception $e) {
            return back()->with('warningPassword', 'Impossibile modificare la password!');
        }
        return back()->with('successPassword', 'Password modificata con successo!');
    }
}
