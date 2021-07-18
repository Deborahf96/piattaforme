<?php

namespace App\Http\Controllers;

use App\Attivita;
use App\Prenotazione;
use App\Camera;
use App\Cliente;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class PrenotazioneController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('prenotazioni.index');
    }

    public function prenota(Request $request)
    {
        $data_checkin = $request->data_checkin ?? Carbon::now()->format('Y-m-d');
        $data_checkout = $request->data_checkout;
        $num_persone = $request->num_persone;
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
        $camera = Camera::where('numero', $request->camera_numero)->first();
        $costo_totale = (Carbon::parse($request->data_checkin)->diffinDays(Carbon::parse($request->data_checkout), false))*$camera->costo_a_notte;
        $data = [
            'metodo_pagamento_enum' => Enums::metodo_pagamento_enum(),
            'clienti' => Cliente::all()->pluck("utente.name", "user_id")->sort(),
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

    public function prenotaCamera(Request $request)
    {
        if(Auth::user()->id_level == 0) {
            if($request->email) {
                if(!($request->cliente))
                    return "Attenzione! Compila il campo 'Nuovo cliente'";
                if(User::where('email', $request->email)->exists())
                    return 'Attenzione! Email ('.$request->email.') già registrata';
            }
            if($request->cliente && !($request->email))
                return "Attenzione! Compila il campo 'Email'";
            if(!$request->cliente && !$request->cliente_user_id)
                return "Attenzione! Inserire dati cliente";
        }
        DB::beginTransaction();
        try{
            $prenotazione = $this->salva_prenotazione($request);
            PrenotazioneUtil::salva_attivita($request, $prenotazione);
            DB::commit();
        } catch(Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
        return $prenotazione->id;
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

    public function conferma_annulla_check(Request $request)
    {
        $prenotazione = Prenotazione::find($request->id);
        $prenotazione->check_pernottamento = $prenotazione->check_pernottamento == 'Confermato' ? 'Non confermato' : 'Confermato';
        $prenotazione->conferma_pagamento = true;
        $prenotazione->save();
        return $prenotazione ? response()->json(true,200) : response()->json(false, 400);
    }

    public function elimina(Request $request)
    {
        $prenotazione = Prenotazione::find($request->id)->delete();
        return $prenotazione ? response()->json(true,200) : response()->json(false, 400);
    }

    public function tablePrenotazioni()
    {
        $prenotazioni = $this->recupera_prenotazioni();
        return $this->genera_datatable($prenotazioni);
    }

    public function pagamento(Request $request)
    {
        $prenotazione = Prenotazione::find($request->id);
        $prenotazione->conferma_pagamento = true;
        return $prenotazione->save() ? response()->json(true) : response()->json(false);
    }

    private function salva_prenotazione(Request $request)
    {
        $prenotazione = new Prenotazione;
        if(Auth::user()->id_level == 0) {
            if($request->cliente && $request->email) {
                $utente = $this->create_user($request);
                $cliente = new Cliente;
                $cliente->user_id = $utente->id;
                $cliente->save();
                $prenotazione->cliente_user_id = $cliente->user_id;
            }else {
                $prenotazione->cliente_user_id = $request->cliente_user_id;
            }
        }else {
            $prenotazione->cliente_user_id = Auth::user()->id;
        }
        $prenotazione->camera_id = $request->camera_id;
        $prenotazione->data_checkin = $request->data_checkin;
        $prenotazione->data_checkout = $request->data_checkout;
        $prenotazione->num_persone = $request->num_persone;
        $prenotazione->metodo_pagamento = $request->metodo_pagamento;
        $prenotazione->importo = $request->costo_totale;  
        $prenotazione->check_pernottamento = 'Non confermato';
        $prenotazione->save();
        return $prenotazione;
    }

    private function recupera_prenotazioni()
    {
        return Prenotazione::join('camera', 'prenotazione.camera_id', 'camera.id')
            ->join('users', 'prenotazione.cliente_user_id', 'users.id')
            ->select(
                'prenotazione.id',
                'prenotazione.data_checkin',
                'prenotazione.data_checkout',
                'prenotazione.importo',
                'prenotazione.check_pernottamento',
                'users.name',
                'camera.numero',
            );
    }

    private function genera_datatable($prenotazioni)
    {
        return DataTables::of($prenotazioni)
        ->filterColumn("numero", function ($q, $k) { return $q->whereRaw("camera.numero LIKE ?", ["%$k%"]); })
        ->filterColumn("name", function ($q, $k) { return $q->whereRaw("users.name LIKE ?", ["%$k%"]); })
        ->filterColumn("", function ($q, $k) { return ''; })
        ->filterColumn(null, function ($q, $k) { return ''; })
        ->make(true);
    }

    private function create_user(Request $request)
    {
        $user = new User;
        $user->name = $request->cliente;
        $user->email = $request->email;
        $user->password = Hash::make('password');
        $user->id_level = 1;
        $user->save();
        return $user;
    }
}
