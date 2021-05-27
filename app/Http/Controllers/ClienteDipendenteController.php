<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Prenotazione;
use App\User;
use Yajra\DataTables\Facades\DataTables;

class ClienteDipendenteController extends Controller
{
    public function __construct()
    {
        $this->middleware('dipendenti');
    }

    public function index()
    {
        return view('clienti.index');
    }

    public function show($user_id)
    {
        $data = [
            'cliente' => Cliente::where('user_id', $user_id)->first(),
            'prenotazioni_cliente' => Prenotazione::where('cliente_user_id', $user_id),
        ];
        return view('clienti.show', $data);
    }

    public function prenotazioni($user_id)
    {
        $data = [
            'prenotazioni' => Prenotazione::where('cliente_user_id', $user_id)->get(),
            'cliente_name' => User::where('id', $user_id)->value('name'),
        ];
        return view('clienti.prenotazioni', $data);
    }

    public function tableClienti()
    {
        $clienti = $this->recupera_clienti();
        return $this->genera_datatable($clienti);
    }

    private function recupera_clienti()
    {
        return Cliente::join('users', 'cliente.user_id', 'users.id')
            ->select(
                'cliente.user_id',
                'users.name',
                'users.email'
            );
    }

    private function genera_datatable($clienti)
    {
        return DataTables::of($clienti)
        ->filterColumn("name", function ($q, $k) { return $q->whereRaw("users.name LIKE ?", ["%$k%"]); })
        ->filterColumn("email", function ($q, $k) { return $q->whereRaw("users.email LIKE ?", ["%$k%"]); })
        ->filterColumn("", function ($q, $k) { return ''; })
        ->filterColumn(null, function ($q, $k) { return ''; })
        ->make(true);
    }
}
