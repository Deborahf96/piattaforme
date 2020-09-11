<?php

namespace App\Http\Middleware;

use App\Cliente;
use Closure;

class CheckClienti
{
    public function handle($request, Closure $next)
    {
        $cliente = Cliente::where('user_id', auth()->user()->id)->first();
        if ($cliente == null) {
            return redirect('/accesso_negato_clienti')->with('error', "Errore!");
        }
        return $next($request);
    }
}
