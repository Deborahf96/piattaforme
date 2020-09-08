<?php

namespace App\Http\Controllers;

use App\Prenotazione;
use App\Camera;
use App\Cliente;
use Illuminate\Http\Request;

class PrenotazioneController extends Controller
{
   
    public function index()
    {
        $prenotazioni = Prenotazione::all();
        $data = [
            'prenotazioni' => $prenotazioni
        ];
        return view('prenotazioni.index', $data);
    }
    
    public function create()
    {
        $data = [
            'metodo_pagamento_enum' => Enums::metodo_pagamento_enum(),
            'camere' => Camera::all()->pluck("numero", "numero")->sort(),
            //'clienti' => Cliente::all()->pluck("cliente", "user_id")->sort(),
        ];
        return view('prenotazioni.create', $data);
    }

    public function store(Request $request)
    {
        $prenotazione = new Prenotazione;
        $this->valida_richiesta($request, $prenotazione->id);
        $this->salva_prenotazione($request, $prenotazione);
        return redirect('/prenotazioni')->with('success', 'Prenotazione inserita con successo');
    }

    public function show($id)
    {
        $prenotazione = Prenotazione::find($id);
        $data = [
            'prenotazione' => $prenotazione
        ];
        return view ('prenotazioni.show', $data);
    }

    public function edit($id)
    {
        $prenotazione = Prenotazione::find($id);
        $data = [
            'prenotazione' => $prenotazione,
            'metodo_pagamento_enum' => Enums::metodo_pagamento_enum(),
            'camere' => Camera::all()->pluck("numero", "numero")->sort(),
            //'clienti' => Cliente::all()->pluck("cliente", "user_id")->sort(),
        ];
        return view('prenotazioni.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $prenotazione = Prenotazione::find($id);
        $this->valida_richiesta($request, $id);
        $this->salva_prenotazione($request, $prenotazione);
        return redirect('/prenotazioni')->with('success','Prenotazione modificata con successo');
    }

    public function destroy($id)
    {        
        $prenotazione = Prenotazione::find($id);
        $prenotazione->delete();
        return redirect('/prenotazioni')->with('success', 'Prenotazione eliminata con successo');
    }

    private function valida_richiesta(Request $request, $id)
    {
        $rules = [
            'camera_numero' => 'required|unique_camera_datain_dataout:'.$request->data_checkin.','.$request->data_checkout.','.$id,
            'data_checkin' => 'required|date',
            'data_checkout'=> 'required|date|date_greater_than:'.$request->data_checkin. ','.$request->data_checkout,
            //'cliente_user_id' => 'required',
            //va inserito l'attributo cliente (quello nome e cognome)
            'num_persone' => 'required|numeric',
            'metodo_pagamento' => 'required',
        ];
        $customMessages = [
            'camera_numero.required' => "E' necessario inserire il parametro 'Camera'",
            'camera_numero.numeric' => "Il campo 'Camera' può contenere solo numeri",
            'data_checkin.required' => "E' necessario inserire il parametro 'Data checkin'",
            'data_checkin.date' => "E' necessario inserire una data per il campo 'Data checkin'",
            'data_checkout.required' => "E' necessario inserire il parametro 'Data checkout'",
            'data_checkout.date' => "E' necessario inserire una data per il campo 'Data checkout'",
            //'cliente_user_id.required' => "E' necessario inserire il parametro 'Cliente'",
            'num_persone.required' => "E' necessario inserire il parametro 'Numero persone'",
            'num_persone.numeric' => "Il campo 'Numero persone' può contenere solo numeri",
            'metodo_pagamento' => "E' necessario inserire il parametro 'Metodo di pagamento'",
        ];

        $this->validate($request, $rules, $customMessages);
    }

    private function salva_prenotazione(Request $request, $prenotazione)
    {
        $prenotazione->camera_numero = $request->input('camera_numero');
        $prenotazione->data_checkin = $request->input('data_checkin');
        $prenotazione->data_checkout = $request->input('data_checkout');
        //$prenotazione->cliente_user_id = $request->input('cliente_user_id');
        $prenotazione->cliente = $request->input('cliente');
        $prenotazione->num_persone = $request->input('num_persone');
        $prenotazione->metodo_pagamento = $request->input('metodo_pagamento');
        $prenotazione->save();
    }

}
