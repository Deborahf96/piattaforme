<?php

namespace App\Http\Controllers;

use App\Attivita;
use App\Prenotazione;
use App\Camera;
use App\Cliente;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PrenotazioneController extends Controller
{
    public function __construct()
    {
        $this->middleware('dipendenti');
    }

    public function index(Request $request)
    {
        $data_corrente = $request->input('data_corrente');
        $prenotazioni = Prenotazione::when(isset($data_corrente), function ($query) use ($data_corrente) {
                                    return $query->where('data_checkin', '<=', $data_corrente)
                                                ->where('data_checkout', ">=", $data_corrente);
                                    })->get();
        $data = [
            'prenotazioni' => $prenotazioni,
            'data_corrente' => $data_corrente,
        ];
        return view('prenotazioni.index', $data);
    }

    public function prenota(Request $request)
    {
        $data_checkin = $request->input('data_checkin') ?? Carbon::now()->format('Y-m-d');
        $data_checkout = $request->input('data_checkout');
        $num_persone = $request->input('num_persone');
        if (!isset($data_checkout) || !isset($num_persone)) {
            $camere = [];
        } else {
            PrenotazioneUtil::valida_campi($request, $this);
            $camere_escluse = PrenotazioneUtil::camere_escluse($data_checkin, $data_checkout, $num_persone);
            $camere = Camera::where('numero_letti', '>=', $num_persone)
                      ->whereNotIn('numero', $camere_escluse)->get();
        }
        $data = [
            'camere' => $camere,
            'data_checkin' => $data_checkin,
            'data_checkout' => $data_checkout,
            'num_persone' => $num_persone
        ];
        return view('prenotazioni.prenota', $data);
    }

    public function create(Request $request)
    {
        $camera_numero = $request->input('camera_numero');
        $data_checkin = $request->input('data_checkin');
        $data_checkout = $request->input('data_checkout');
        $num_persone = $request->input('num_persone');
        $costo_totale = $request->input('costo_totale');
        $attivita = Attivita::where('data', '>', $data_checkin)
                            ->where('data', '<=', $data_checkout)
                            ->get();
        $data = [
            'metodo_pagamento_enum' => Enums::metodo_pagamento_enum(),
            'clienti' => Cliente::all()->pluck("utente.name", "user_id")->sort(),
            'camere' => Camera::all()->pluck('numero')->sort(),
            'camera_numero' => $camera_numero,
            'data_checkin' => $data_checkin,
            'data_checkout' => $data_checkout,
            'num_persone' => $num_persone,
            'costo_totale' => $costo_totale,
            'attivita' => $attivita,
        ];
        return view('prenotazioni.create', $data);
    }

    public function store(Request $request)
    {
        $prenotazione = new Prenotazione;
        $this->valida_richiesta($request, $prenotazione->id);
        $this->salva_prenotazione($request, $prenotazione);
        PrenotazioneUtil::salva_attivita($request, $prenotazione);
        return redirect("/prenotazioni/$prenotazione->id/riepilogo")->with('success', 'Prenotazione effettuata con successo');
    }

    public function riepilogo($id)
    {
        $prenotazione = Prenotazione::find($id);
        $cliente_name = User::where('id', $prenotazione->cliente_user_id)->value('name');
        $data = [
            'prenotazione' => $prenotazione,
            'cliente_name' => $cliente_name,
        ];
        return view("prenotazioni.riepilogo", $data);
    }

    public function show($id)
    {
        $prenotazione = Prenotazione::find($id);
        $cliente_name = User::where('id', $prenotazione->cliente_user_id)->value('name');
        $data = [
            'prenotazione' => $prenotazione,
            'cliente_name' => $cliente_name,
        ];
        return view('prenotazioni.show', $data);
    }

    public function conferma_annulla_check(Request $request, $id)
    {
        $prenotazione = Prenotazione::find($id);
        $prenotazione->check_pernottamento = $prenotazione->check_pernottamento == 'Confermato' ? 'Non confermato' : 'Confermato';
        $prenotazione->save();
        return back()->with('success', 'Prenotazione aggiornata con successo');
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
            'cliente_user_id' => 'nullable',
            'cliente' => 'nullable|max:255',
            'metodo_pagamento' => 'required',
        ];
        $customMessages = [
            'camera_numero.required' => "E' necessario inserire il parametro 'Camera'",
            'cliente.max' => "Il numero massimo di caratteri consentito per 'Cliente' è 255",
            'metodo_pagamento.required' => "E' necessario inserire il parametro 'Metodo di pagamento'",
        ];

        $this->validate($request, $rules, $customMessages);
    }

    private function salva_prenotazione(Request $request, $prenotazione)
    {
        $prenotazione->check_pernottamento = 'Non confermato';
        $prenotazione->camera_numero = $request->input('camera_numero');
        $prenotazione->cliente_user_id = $request->input('cliente_user_id');
        $prenotazione->cliente = $request->input('cliente');
        $prenotazione->data_checkin = $request->input('data_checkin');
        $prenotazione->data_checkout = $request->input('data_checkout');
        $prenotazione->num_persone = $request->input('num_persone');
        $prenotazione->importo = $request->input('costo_totale');  
        $prenotazione->metodo_pagamento = $request->input('metodo_pagamento');
        $prenotazione->save();
    }
}
