<?php

namespace App\Http\Middleware;

use App\Dipendente;
use Closure;

class CheckDipendenti
{
    public function handle($request, Closure $next)
    {
        $dipendente = Dipendente::where('user_id', auth()->user()->id)->first();
        if ($dipendente == null) {
            return redirect('/accesso_negato_dipendenti')->with('error', "Errore!");
        }
        return $next($request);
    }
}
