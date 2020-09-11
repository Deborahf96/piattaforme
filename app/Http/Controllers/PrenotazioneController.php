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
        $data_checkin = $request->input('data_checkin') ?? Carbon::now()->format('Y-m-d');
        $data_checkout = $request->input('data_checkout');
        $num_persone = $request->input('num_persone');
        if (!isset($data_checkout) || !isset($num_persone)) {
            $camere = [];
        } else {
            $this->valida_campi($request);
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

    public function create(Request $request)
    {
        $camera_numero = $request->input('camera_numero');
        $data_checkin = $request->input('data_checkin');
        $data_checkout = $request->input('data_checkout');
        $num_persone = $request->input('num_persone');
        $costo_totale = $request->input('costo_totale');
        $data = [
            'metodo_pagamento_enum' => Enums::metodo_pagamento_enum(),
            'clienti' => Cliente::all()->pluck("utente.name", "user_id")->sort(),
            'camere' => Camera::all()->pluck('numero')->sort(),
            'camera_numero' => $camera_numero,
            'data_checkin' => $data_checkin,
            'data_checkout' => $data_checkout,
            'num_persone' => $num_persone,
            'costo_totale' => $costo_totale,
        ];
        return view('prenotazioni.create', $data);
    }

    public function store(Request $request)
    {
        $prenotazione = new Prenotazione;
        $this->valida_richiesta($request, $prenotazione->id);
        $this->salva_prenotazione($request, $prenotazione);
        $attivita = Attivita::where('data', '>', $prenotazione->data_checkin)
                            ->where('data', '<=', $prenotazione->data_checkout)
                            ->get();
        $data = [
            'attivita' => $attivita,
            'prenotazione_id' => $prenotazione->id,
        ];
        return view("prenotazioni.attivita.seleziona_attivita", $data);
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

    private function camere_escluse($data_checkin, $data_checkout, $num_persone){
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

    private function valida_campi(Request $request){
        $rules = [
            'data_checkin' => 'nullable|date|current_date_greater_than_equals',
            'data_checkout' => 'nullable|date|date_greater_than:' . $request->data_checkin,
            'num_persone' => 'nullable|numeric|gt:0',
        ];
        $customMessages = [
            'data_checkin.date' => "E' necessario inserire una data per il campo 'Data checkin'",
            'data_checkout.date' => "E' necessario inserire una data per il campo 'Data checkout'",
            'num_persone.numeric' => "Il campo 'Posti letto' può contenere solo numeri",
            'num_persone.gt' => "Il campo 'Posti letto' deve essere maggiore di zero",
        ];

        $this->validate($request, $rules, $customMessages);
    }
}
