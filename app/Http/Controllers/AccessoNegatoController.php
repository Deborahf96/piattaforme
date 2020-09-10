<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccessoNegatoController extends Controller
{
    public function accesso_negato_clienti()
    {
        return view('accesso_negato.accesso_negato_clienti');
    }
    
    public function accesso_negato_dipendenti()
    {
        return view('accesso_negato.accesso_negato_dipendenti');
    }
}
