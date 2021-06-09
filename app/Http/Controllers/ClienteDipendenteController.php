<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Prenotazione;
use App\User;
use Symfony\Component\HttpFoundation\Request;
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
            'cliente' => User::find($user_id),
        ];
        return view('clienti.prenotazioni', $data);
    }

    public function tableClienti()
    {
        $clienti = $this->recupera_clienti();
        return $this->genera_datatable_clienti($clienti);
    }

    public function tablePrenotazioniCliente(Request $request)
    {
        $prenotazioni = $this->recupera_prenotazioni($request->id);
        return $this->genera_datatable_prenotazioni($prenotazioni);
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

    private function genera_datatable_clienti($clienti)
    {
        return DataTables::of($clienti)
        ->filterColumn("name", function ($q, $k) { return $q->whereRaw("users.name LIKE ?", ["%$k%"]); })
        ->filterColumn("email", function ($q, $k) { return $q->whereRaw("users.email LIKE ?", ["%$k%"]); })
        ->filterColumn("", function ($q, $k) { return ''; })
        ->filterColumn(null, function ($q, $k) { return ''; })
        ->make(true);
    }

    private function recupera_prenotazioni($id)
    {
        return Prenotazione::where('cliente_user_id', $id)
            ->join('camera', 'prenotazione.camera_id', 'camera.id')
            ->select(
                'prenotazione.id',
                'prenotazione.data_checkin',
                'prenotazione.data_checkout',
                'prenotazione.importo',
                'prenotazione.check_pernottamento',
                'camera.numero',
            );
    }

    private function genera_datatable_prenotazioni($prenotazioni)
    {
        return DataTables::of($prenotazioni)
        ->filterColumn("numero", function ($q, $k) { return $q->whereRaw("camera.numero LIKE ?", ["%$k%"]); })
        ->filterColumn("", function ($q, $k) { return ''; })
        ->filterColumn(null, function ($q, $k) { return ''; })
        ->make(true);
    }
}
