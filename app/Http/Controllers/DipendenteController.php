<?php

namespace App\Http\Controllers;

use App\Dipendente;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DipendenteController extends Controller
{
    public function index()
    {
        $dipendenti = Dipendente::all();
        $data = [
            'dipendenti' => $dipendenti,
        ];
        return view('dipendenti.index', $data);
    }

    public function create()
    {
        return view('dipendenti.create');
    }

    public function store(Request $request)
    {
        $dipendente = new Dipendente;
        $user = new User;
        //$this->valida_richiesta($request);
        $this->salva_dipendente($request, $dipendente, $user);
        return redirect('/dipendenti/' . $dipendente->user_id)->with('success', 'Dipendente inserito con successo');
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
        ];
        return view('dipendenti.edit', $data);
    }

    public function update(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $dipendente = Dipendente::where('user_id', $user_id)->first();
        //$this->valida_richiesta($request);
        $this->salva_dipendente($request, $dipendente, $user);
        return redirect('/dipendenti/'. $dipendente->user_id)->with('success', 'Dipendente inserito con successo');
    }

    public function destroy($user_id)
    {
        $dipendente = Dipendente::where('user_id', $user_id)->first();
        $dipendente->delete();
        return redirect('/dipendenti')->with('success', 'Dipendente eliminato con successo');
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
