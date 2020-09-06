<?php

namespace App\Http\Controllers;

use App\Dipendente;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DipendenteController extends Controller
{
    public function index(Request $request)
    {
        $ruolo_corrente = $request->input('ruolo');
        $dipendenti = Dipendente::when(isset($ruolo_corrente), function($query) use ($ruolo_corrente){
                                return $query->where('ruolo', $ruolo_corrente);
                                })->get();
        $data = [
            'dipendenti' => $dipendenti,
            'dipendente_ruolo_enum' => Enums::dipendente_ruolo_enum(),
            'ruolo_corrente' => $ruolo_corrente,
        ];
        return view('dipendenti.index', $data);
    }

    public function create()
    {
        $data = [
            'dipendente_ruolo_enum' => Enums::dipendente_ruolo_enum(),
            'dipendente_tipo_contratto_enum' => Enums::tipo_contratto_enum(),
        ];
        return view('dipendenti.create', $data);
    }

    public function store(Request $request)
    {
        $dipendente = new Dipendente;
        $user = new User;
        $this->valida_richiesta($request, $dipendente->user_id);
        $this->salva_dipendente($request, $dipendente, $user);
        return redirect('/dipendenti')->with('success', 'Dipendente inserito con successo');
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

    public function update(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $dipendente = Dipendente::where('user_id', $user_id)->first();
        $this->valida_richiesta($request, $user_id);
        $this->salva_dipendente($request, $dipendente, $user);
        return redirect('/dipendenti')->with('success', 'Dipendente modificato con successo');
    }

    public function destroy($user_id)
    {
        $dipendente = Dipendente::where('user_id', $user_id)->first();
        $dipendente->delete();
        return redirect('/dipendenti')->with('success', 'Dipendente eliminato con successo');
    }

    private function valida_richiesta(Request $request, $user_id)
    {
        $rules = [
            'nome' => 'required|max:255',
            'cognome' => 'required|max:255',
            'data_nascita' => 'required|date',
            'luogo_nascita' => 'required|max:255',
            'indirizzo' => 'required|max:255',
            'telefono' => 'required|min:9|max:10',
            'email' => 'required|email|unique:users,email,'.$user_id,
            'iban' => 'required|min:27|max:27',
            'ruolo' => 'required',
            'tipo_contratto' => 'required',
            'stipendio' => 'required|max:255',
            'data_inizio' => 'required|date',
            'data_fine' => 'nullable|date|date_greater_than:'.$request->data_inizio,
            'ore_settimanali' => 'required|numeric',
        ];
        $customMessages = [
            'nome.required' => "E' necessario inserire il parametro 'Nome'",
            'nome.max' => "Il numero massimo di caratteri consentito per 'Nome' è 255",
            'cognome.required' => "E' necessario inserire il parametro 'Cognome'",
            'cognome.max' => "Il numero massimo di caratteri consentito per 'Cognome' è 255",
            'data_nascita.required' => "E' necessario inserire il parametro 'Data di nascita'",
            'data_nascita.date' => "E' necessario inserire una data per il campo 'Data di nascita'",
            'luogo_nascita.required' => "E' necessario inserire il parametro 'Luogo di nascita'",
            'luogo_nascita.max' => "Il numero massimo di caratteri consentito per 'Luogo di nascita' è 255",
            'indirizzo.required' => "E' necessario inserire il parametro 'Indirizzo'",
            'indirizzo.max' => "Il numero massimo di caratteri consentito per 'Indirizzo' è 255",
            'telefono.required' => "E' necessario inserire il parametro 'Telefono'",
            'telefono.min' => "Il numero minimo di caratteri consentito per 'Telefono' è 9",
            'telefono.max' => "Il numero massimo di caratteri consentito per 'Telefono' è 10",
            'email.required' => "E' necessario inserire il parametro 'Email'",
            'email.email' => "Formato email errato",
            'iban.required' => "E' necessario inserire il parametro 'IBAN'",
            'iban.min' => "Il numero minimo di caratteri consentito per 'IBAN' è 27",
            'iban.max' => "Il numero massimo di caratteri consentito per 'IBAN' è 27",
            'ruolo.required' => "E' necessario inserire il parametro 'Ruolo'",
            'tipo_contratto.required' => "E' necessario inserire il parametro 'Tipo contratto'",
            'stipendio.required' => "E' necessario inserire il parametro 'Stipendio'",
            'stipendio.max' => "Il numero massimo di caratteri consentito per 'Stipendio' è 255",
            'data_inizio.required' => "E' necessario inserire il parametro 'Data inizio'",
            'data_inizio.date' => "E' necessario inserire una data per il campo 'Data inizio'",
            'data_fine.date' => "E' necessario inserire una data per il campo 'Data fine'",
            'ore_settimanali.required' => "E' necessario inserire il parametro 'Ore settimanali'",
            'ore_settimanali.numeric' => "Il campo 'Ore settimanali' deve contenere solo numeri",
        ];
        $this->validate($request, $rules, $customMessages);
    }

    private function salva_dipendente(Request $request, $dipendente, $user)
    {
        $this->salva_utente($request, $user);
        $dipendente->user_id = $user->id;
        $dipendente->iban = $request->input('iban');
        $dipendente->ruolo = $request->input('ruolo');
        $dipendente->tipo_contratto = $request->input('tipo_contratto');
        $dipendente->stipendio = $request->input('stipendio');
        $dipendente->data_inizio = $request->input('data_inizio');
        $dipendente->data_fine = $request->input('data_fine');
        $dipendente->ore_settimanali = $request->input('ore_settimanali');
        $dipendente->save();
    }

    private function salva_utente(Request $request, $user)
    {
        $user->name = $request->input('nome');
        $user->cognome = $request->input('cognome');
        $user->data_nascita = $request->input('data_nascita');
        $user->luogo_nascita = $request->input('luogo_nascita');
        $user->indirizzo = $request->input('indirizzo');
        $user->telefono = $request->input('telefono');
        $user->email = $request->input('email');
        $user->password = Hash::make('password');
        $user->save();
    }
}
