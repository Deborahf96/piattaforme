<?php

namespace App\Http\Controllers;

use App\Attivita;
use App\Camera;
use App\Cliente;
use App\Prenotazione;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrenotazioneClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('clienti');
    }

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
        return view('prenotazioni_cliente.prenota', $data);
    }

    public function create(Request $request)
    {
        $user_id = Auth::user()->id;
        $pagamento_default = Cliente::where('user_id', $user_id)->first()->metodo_pagamento;
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
            'pagamento_default' => isset($pagamento_default) ? $pagamento_default : '',
            'camere' => Camera::all()->pluck('numero')->sort(),
            'camera_numero' => $camera_numero,
            'data_checkin' => $data_checkin,
            'data_checkout' => $data_checkout,
            'num_persone' => $num_persone,
            'costo_totale' => $costo_totale,
            'attivita' => $attivita,
        ];
        return view('prenotazioni_cliente.create', $data);
    }

    public function store(Request $request)
    {
        $prenotazione = new Prenotazione;
        $this->valida_richiesta($request, $prenotazione->id);
        $this->salva_prenotazione($request, $prenotazione);
        $this->salva_attivita($request, $prenotazione);
        return redirect("/prenotazioni_cliente/$prenotazione->id/riepilogo")->with('success', 'Prenotazione effettuata con successo');
    }

    public function riepilogo($id)
    {
        $prenotazione = Prenotazione::find($id);
        $cliente_name = User::where('id', $prenotazione->cliente_user_id)->value('name');
        $data = [
            'prenotazione' => $prenotazione,
            'cliente_name' => $cliente_name,
        ];
        return view("prenotazioni_cliente.riepilogo", $data);
    }

    public function show($id)
    {
        $prenotazione = Prenotazione::find($id);
        $data = [
            'prenotazione' => $prenotazione,
        ];
        return view('prenotazioni_cliente.show', $data);
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
            'camera_numero' => 'required|unique_camera_datain_dataout:' . $request->data_checkin . ',' . $request->data_checkout . ',' . $id,
            'metodo_pagamento' => 'required',
        ];
        $customMessages = [
            'camera_numero.required' => "E' necessario inserire il parametro 'Camera'",
            'metodo_pagamento.required' => "E' necessario inserire il parametro 'Metodo di pagamento'",
        ];

        $this->validate($request, $rules, $customMessages);
    }

    private function salva_prenotazione(Request $request, $prenotazione)
    {
        $prenotazione->cliente_user_id = Auth::user()->id;
        $prenotazione->camera_numero = $request->input('camera_numero');
        $prenotazione->data_checkin = $request->input('data_checkin');
        $prenotazione->data_checkout = $request->input('data_checkout');
        $prenotazione->num_persone = $request->input('num_persone');
        $prenotazione->camera_numero = $request->input('camera_numero');
        $prenotazione->metodo_pagamento = $request->input('metodo_pagamento');
        $prenotazione->importo = $request->input('costo_totale');  
        $prenotazione->check_pernottamento = "Non confermato";
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

    private function salva_attivita($request, $prenotazione)
    {
        $lista_attivita = $request->input('attivita');
        if(isset($lista_attivita))
            foreach($lista_attivita as $singola_attivita_id)
            {
                $attivita = Attivita::find($singola_attivita_id);
                $prenotazione->attivita()->attach($attivita);
                $prenotazione->importo = $prenotazione->importo + $attivita->costo;
                $prenotazione->save();
            }
    }
}
