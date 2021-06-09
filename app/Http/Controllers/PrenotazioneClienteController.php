<?php

namespace App\Http\Controllers;

use App\Attivita;
use App\Camera;
use App\Cliente;
use App\Prenotazione;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class PrenotazioneClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('clienti');
    }

    public function index()
    {
        $data = [
            'prenotazioni' => Prenotazione::where('cliente_user_id', Auth::user()->id)->get()
        ];
        return view('prenotazioni_cliente.index', $data);
    }

    public function create(Request $request)
    {
        $pagamento_default = Cliente::where('user_id', Auth::user()->id)->first()->metodo_pagamento;
        $camera = Camera::where('numero', $request->camera_numero)->first();
        $costo_totale = (Carbon::parse($request->data_checkin)->diffinDays(Carbon::parse($request->data_checkout), false))*$camera->costo_a_notte;
        $data = [
            'metodo_pagamento_enum' => Enums::metodo_pagamento_enum(),
            'pagamento_default' => isset($pagamento_default) ? $pagamento_default : '',
            'camera' => $camera,
            'data_checkin' => $request->data_checkin,
            'data_checkout' => $request->data_checkout,
            'num_persone' => $request->num_persone,
            'costo_totale' => $costo_totale,
            'attivita' => Attivita::where('data', '>', $request->data_checkin)
                                ->where('data', '<=', $request->data_checkout)
                                ->get(),
        ];
        return view('prenotazioni.create', $data);
    }

    public function show($id)
    {
        $data = [
            'prenotazione' => Prenotazione::find($id),
        ];
        return view('prenotazioni_cliente.show', $data);
    }

    public function tablePrenotazioni()
    {
        $prenotazioni = $this->recupera_prenotazioni();
        return $this->genera_datatable($prenotazioni);
    }

    private function recupera_prenotazioni()
    {
        return Prenotazione::where('cliente_user_id', Auth::user()->id)
            ->join('camera', 'prenotazione.camera_id', 'camera.id')
            ->select(
                'prenotazione.id',
                'prenotazione.data_checkin',
                'prenotazione.data_checkout',
                'prenotazione.importo',
                'camera.numero',
            );
    }

    private function genera_datatable($prenotazioni)
    {
        return DataTables::of($prenotazioni)
        ->filterColumn("numero", function ($q, $k) { return $q->whereRaw("camera.numero LIKE ?", ["%$k%"]); })
        ->filterColumn("", function ($q, $k) { return ''; })
        ->filterColumn(null, function ($q, $k) { return ''; })
        ->make(true);
    }
}
