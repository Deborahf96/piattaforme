<?php

namespace App\Http\Controllers;

use App\Cliente;

class ClienteDipendenteController extends Controller
{
    public function __construct()
    {
        $this->middleware('dipendenti');
    }

    public function index() //lato dipendente
    {
        $clienti = Cliente::all();
        $data = [
            'clienti' => $clienti
        ];
        return view('clienti_latoDipendente.index', $data);
    }

    public function show($user_id)
    {
        $cliente = Cliente::where('user_id', $user_id)->first();
        $data = [
            'cliente' => $cliente
        ];
        return view('clienti_latoDipendente.show', $data);
    }
}
