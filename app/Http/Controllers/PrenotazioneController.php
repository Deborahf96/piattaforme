<?php

namespace App\Http\Controllers;

use App\Prenotazione;
use App\Camera;
use App\Cliente;
use App\User;
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

    public function prenota(Request $request)
    {
        $data_checkin = $request->input('data_checkin');
        $data_checkout = $request->input('data_checkout');
        $num_persone = $request->input('num_persone');
        if (!isset($data_checkin) || !isset($data_checkout) || !isset($num_persone)) {
            $camere = [];
        } else {
            $camere_escluse = $this->camere_escluse($data_checkin, $data_checkout, $num_persone);
            $camere = Camera::whereNotIn('numero', $camere_escluse)->get();
        }

        $data = [
            'camere' => $camere,
            'data_checkin' => $data_checkin,
            'data_checkout' => $data_checkout,
            'num_persone' => $num_persone
        ];
        return view('prenotazioni.prenota', $data);
    }

    public function create()
    {
        $data = [
            'metodo_pagamento_enum' => Enums::metodo_pagamento_enum(),
            'camere' => Camera::all()->pluck("numero", "numero")->sort(),
            'clienti' => Cliente::all()->pluck("utente.name", "user_id")->sort(),
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
        $cliente_name = User::where('id', $id)->value('name');
        if ($prenotazione->check_pernottamento == '1') {
            $valore = '1';
        } else {
            $valore = '0';
        }
        $data = [
            'prenotazione' => $prenotazione,
            'cliente_name' => $cliente_name,
            'valore' => $valore
        ];
        return view('prenotazioni.show', $data);
    }

    public function update(Request $request, $id)
    {
        $prenotazione = Prenotazione::find($id);
        $this->valida_check($request);
        $this->salva_check($request, $prenotazione);
        return redirect('/prenotazioni')->with('success', 'Pernottamento modificato con successo');
    }

    public function destroy($id)
    {
        $prenotazione = Prenotazione::find($id);
        $prenotazione->delete();
        return redirect('/prenotazioni')->with('success', 'Prenotazione annullata con successo');
    }

    private function valida_richiesta(Request $request, $id)
    {
        $rules = [
            'camera_numero' => 'required|unique_camera_datain_dataout:' . $request->data_checkin . ',' . $request->data_checkout . ',' . $id,
            'data_checkin' => 'required|date|current_date_greater_than:',
            'data_checkout' => 'required|date|date_greater_than:' . $request->data_checkin,
            'cliente_user_id' => 'nullable',
            'cliente' => 'nullable|max:255',
            'num_persone' => 'required|numeric',
            'metodo_pagamento' => 'required',
        ];
        $customMessages = [
            'camera_numero.required' => "E' necessario inserire il parametro 'Camera'",
            'data_checkin.required' => "E' necessario inserire il parametro 'Data checkin'",
            'data_checkin.date' => "E' necessario inserire una data per il campo 'Data checkin'",
            'data_checkout.required' => "E' necessario inserire il parametro 'Data checkout'",
            'data_checkout.date' => "E' necessario inserire una data per il campo 'Data checkout'",
            'cliente.max' => "Il numero massimo di caratteri consentito per 'Cliente' è 255",
            'num_persone.required' => "E' necessario inserire il parametro 'Numero persone'",
            'num_persone.numeric' => "Il campo 'Numero persone' può contenere solo numeri",
            'metodo_pagamento.required' => "E' necessario inserire il parametro 'Metodo di pagamento'",
        ];

        $this->validate($request, $rules, $customMessages);
    }

    private function salva_prenotazione(Request $request, $prenotazione)
    {
        $prenotazione->camera_numero = $request->input('camera_numero');
        $prenotazione->data_checkin = $request->input('data_checkin');
        $prenotazione->data_checkout = $request->input('data_checkout');
        $prenotazione->cliente_user_id = $request->input('cliente_user_id');
        $prenotazione->cliente = $request->input('cliente');
        $prenotazione->num_persone = $request->input('num_persone');
        $prenotazione->metodo_pagamento = $request->input('metodo_pagamento');
        $prenotazione->save();
    }

    public function valida_check(Request $request)
    {
        $rules = [
            'check_pernottamento' => 'nullable'
        ];
        $customMessages = [
            // 'check_pernottamento.accepted' => "Il campo 'Conferma di avvenuto pagamento' non è stato spuntato"
        ];
        $this->validate($request, $rules, $customMessages);
    }

    public function salva_check(Request $request, $prenotazione)
    {
        //dd($request->input('check_pernottamento'));
        if ($request->input('check_pernottamento') == "0") {
            $prenotazione->check_pernottamento = '1';
        } else {
            $prenotazione->check_pernottamento = '0';
        }
        $prenotazione->save();
    }

    public function camere_escluse($data_checkin, $data_checkout, $num_persone){
        return Prenotazione::join('camera', 'prenotazione.camera_numero', '=', 'camera.numero')
                ->where(function ($query) use ($data_checkin, $data_checkout, $num_persone) {
                    $query->where('camera.numero_letti', '>=', $num_persone)
                        ->where('data_checkout', '>', $data_checkin)
                        ->where(function ($query) use ($data_checkout) {
                            $query->where(function ($query) use ($data_checkout) {
                                $query->where('data_checkin', '<', $data_checkout)->where('data_checkout', '>=', $data_checkout);
                            })->orWhere('data_checkout', '<', $data_checkout);
                        });
                })->orWhere('camera.numero_letti', '<', $num_persone)
                ->get()->pluck('numero');
    }
}
