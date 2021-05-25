<?php

namespace App\Http\Controllers;

use App\Dipendente;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class DipendenteController extends Controller
{
    public function __construct()
    {
        $this->middleware('dipendenti');
    }

    public function index()
    {
        return view('dipendenti.index');
    }

    public function create()
    {
        $data = [
            'dipendente_ruolo_enum' => Enums::dipendente_ruolo_enum(),
            'dipendente_tipo_contratto_enum' => Enums::tipo_contratto_enum(),
        ];
        return view('dipendenti.create', $data);
    }

    public function aggiungiDipendente(Request $request)
    {
        if(User::where('email', $request->email)->exists())
            return 'Attenzione! Email ('.$request->email.') già registrata';
        if($request->data_fine != null && Carbon::parse($request->data_inizio)->greaterThanOrEqualTo(Carbon::parse($request->data_fine)))
            return "La data di fine deve essere maggiore della data di inizio";
        DB::beginTransaction();
        try{
            $user = $this->salva_utente($request, new User);
            $this->salva_dipendente($request, new Dipendente, $user->id);
            DB::commit();
        } catch(Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 400);
        }
        return response()->json(true);
    }

    public function show($user_id)
    {
        $dipendente = Dipendente::where('user_id', $user_id)->first();
        $data = [
            'dipendente' => $dipendente,
        ];
        return view('dipendenti.show', $data);
    }

    public function edit($user_id)
    {
        $dipendente = Dipendente::where('user_id', $user_id)->first();
        $data = [
            'dipendente' => $dipendente,
            'dipendente_ruolo_enum' => Enums::dipendente_ruolo_enum(),
            'dipendente_tipo_contratto_enum' => Enums::tipo_contratto_enum(),
        ];
        return view('dipendenti.edit', $data);
    }

    public function modificaDipendente(Request $request)
    {
        if(User::where('id', '!=', $request->user_id)->where('email', $request->email)->exists())
            return 'Attenzione! Email ('.$request->email.') già registrata';
        if($request->data_fine != null && Carbon::parse($request->data_inizio)->greaterThanOrEqualTo(Carbon::parse($request->data_fine)))
            return "La data di fine deve essere maggiore della data di inizio";
        DB::beginTransaction();
        try{
            $user = $this->salva_utente($request, User::find($request->user_id));
            $this->salva_dipendente($request, Dipendente::where('user_id', $request->user_id)->first(), $user->id);
            DB::commit();
        } catch(Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 400);
        }
        return response()->json(true);
    }

    public function elimina(Request $request)
    {
        $dipendente = Dipendente::where('user_id', $request->user_id)->first()->delete();
        return $dipendente ? response()->json(true,200) : response()->json(false, 400);
    }

    public function tableDipendenti()
    {
        $dipendenti = $this->recupera_dipendenti();
        return $this->genera_datatable($dipendenti);
    }
    
    private function salva_dipendente(Request $request, $dipendente, $user_id)
    {
        $dipendente->user_id = $user_id;
        $dipendente->iban = $request->iban;
        $dipendente->ruolo = $request->ruolo;
        $dipendente->tipo_contratto = $request->tipo_contratto;
        $dipendente->stipendio = $request->stipendio;
        $dipendente->data_inizio = $request->data_inizio;
        $dipendente->data_fine = $request->data_fine;
        $dipendente->ore_settimanali = $request->ore_settimanali;
        $dipendente->save();
        return $dipendente;
    }

    private function salva_utente(Request $request, $user)
    {
        $user->name = $request->nome;
        $user->data_nascita = $request->data_nascita;
        $user->luogo_nascita = $request->luogo_nascita;
        $user->indirizzo = $request->indirizzo;
        $user->telefono = $request->telefono;
        $user->email = $request->email;
        $user->password = Hash::make('password');
        $user->save();
        return $user;
    }

    private function recupera_dipendenti()
    {
        return Dipendente::join('users', 'dipendente.user_id', 'users.id')
            ->select(
                'dipendente.user_id',
                'dipendente.ruolo',
                'users.name',
                'users.email'
            );
    }

    private function genera_datatable($dipendenti)
    {
        return DataTables::of($dipendenti)
        ->filterColumn("name", function ($q, $k) { return $q->whereRaw("users.name LIKE ?", ["%$k%"]); })
        ->filterColumn("email", function ($q, $k) { return $q->whereRaw("users.email LIKE ?", ["%$k%"]); })
        ->filterColumn("", function ($q, $k) { return ''; })
        ->filterColumn(null, function ($q, $k) { return ''; })
        ->make(true);
    }
}
