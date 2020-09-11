<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Prenotazione;

class ClienteDipendenteController extends Controller
{
    public function __construct()
    {
        $this->middleware('dipendenti');
    }

    public function index()
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
        $prenotazioni_cliente = Prenotazione::where('cliente_user_id', $user_id);
        $data = [
            'cliente' => $cliente,
            'prenotazioni_cliente' => $prenotazioni_cliente,
        ];
        return view('clienti_latoDipendente.show', $data);
    }

    public function prenotazioni($user_id)
    {
        $prenotazioni = Prenotazione::where('cliente_user_id', $user_id)->get();
        $data = [
            'prenotazioni' => $prenotazioni
        ];
        return view('clienti_latoDipendente.prenotazioni', $data);
    }
}
