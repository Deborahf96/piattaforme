<?php

namespace App\Http\Controllers;

use App\Camera;
use App\Prenotazione;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrenotazioneClienteController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $prenotazioni = Prenotazione::where('cliente_user_id', $user_id)->get();
        $data = [
            'prenotazioni' => $prenotazioni
        ];
        return view('prenotazioni_cliente.index', $data);
    }

    public function prenota(Request $request)
    {
        $data_checkin = $request->input('data_checkin');
        $data_checkout = $request->input('data_checkout');
        $num_persone = $request->input('num_persone');      
        $camere = Camera::all();
        $data = [
            'camere' => $camere,
            'data_checkin' => $data_checkin,
            'data_checkout' => $data_checkout,
            'num_persone' => $num_persone
        ];
        return view('prenotazioni_cliente.prenota', $data);
    }
    
    public function create()
    {
        $data = [
            'metodo_pagamento_enum' => Enums::metodo_pagamento_enum(),
            'camere' => Camera::all()->pluck("numero", "numero")->sort(),
        ];
        return view('prenotazioni_cliente.create', $data);
    }

    public function store(Request $request)
    {
        $prenotazione = new Prenotazione;
        $this->valida_richiesta($request, $prenotazione->id);
        $this->salva_prenotazione($request, $prenotazione);
        return redirect('/prenotazioni_cliente')->with('success', 'Prenotazione effettuata con successo');
    }

    public function show($id)
    {
        $prenotazione = Prenotazione::find($id);
        $data = [
            'prenotazione' => $prenotazione,
        ];
        return view ('prenotazioni_cliente.show', $data);
    }

    public function destroy($id)
    {        
        $prenotazione = Prenotazione::find($id);
        $prenotazione->delete();
        return redirect('/prenotazioni_cliente')->with('success', 'Prenotazione annullata con successo');
    }

    private function valida_richiesta(Request $request, $id)
    {
        $rules = [
            'camera_numero' => 'required|unique_camera_datain_dataout:'.$request->data_checkin.','.$request->data_checkout.','.$id,
            'data_checkin' => 'required|date|current_date_greater_than:',
            'data_checkout'=> 'required|date|date_greater_than:'.$request->data_checkin,
            'num_persone' => 'required|numeric',
            'metodo_pagamento' => 'required',
        ];
        $customMessages = [
            'camera_numero.required' => "E' necessario inserire il parametro 'Camera'",
            'data_checkin.required' => "E' necessario inserire il parametro 'Data checkin'",
            'data_checkin.date' => "E' necessario inserire una data per il campo 'Data checkin'",
            'data_checkout.required' => "E' necessario inserire il parametro 'Data checkout'",
            'data_checkout.date' => "E' necessario inserire una data per il campo 'Data checkout'",
            'num_persone.required' => "E' necessario inserire il parametro 'Numero persone'",
            'num_persone.numeric' => "Il campo 'Numero persone' può contenere solo numeri",
            'metodo_pagamento.required' => "E' necessario inserire il parametro 'Metodo di pagamento'",
        ];

        $this->validate($request, $rules, $customMessages);
    }

    private function salva_prenotazione(Request $request, $prenotazione)
    {
        $prenotazione->cliente = Auth::user()->name;
        $prenotazione->camera_numero = $request->input('camera_numero');
        $prenotazione->data_checkin = $request->input('data_checkin');
        $prenotazione->data_checkout = $request->input('data_checkout');
        $prenotazione->num_persone = $request->input('num_persone');
        $prenotazione->metodo_pagamento = $request->input('metodo_pagamento');
        $prenotazione->save();
    }
}
