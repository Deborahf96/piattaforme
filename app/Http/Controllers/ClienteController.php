<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    public function index()
    {
        $clienti = Cliente::all();
        $data = [
            'clienti' => $clienti
        ];
        return view('clienti.index',$data);
    }
   
    public function show($user_id)
    {
        $cliente = Cliente::where('user_id', $user_id)->first();
        $data = [
            'cliente' => $cliente
        ];
        return view('cliente.show', $data);
    }

    public function edit($user_id)
    {
        $cliente = Cliente::where('user_id', $user_id)->first();
        $data = [
            'cliente' => $cliente,
            'cliente_metodo_pagamento_enum' => Enums::metodo_pagamento_enum(),
        ];
        return view('clienti.edit', $data);
    }

    public function update(Request $request, $user_id) //lato cliente
    {
        $user = User::find($user_id);
        $cliente = Cliente::where('user_id', $user_id)->first();
        $this->valida_richiesta($request, $user_id);
        $this->salva_cliente($request, $cliente, $user);
        return redirect('/clienti.show')->with('success', 'Profilo modificato con successo');
    }

    private function valida_richiesta(Request $request, $user_id)
    {
        $rules = [
            'nome' => 'required|max:255',
            'cognome' => 'required|max:255',
            'data_nascita' => 'nullable|date',
            'luogo_nascita' => 'nullable|max:255',
            'indirizzo' => 'nullable|max:255',
            'telefono' => 'nullable|min:9|max:10',
            'email' => 'required|email|unique:users,email,'.$user_id,
            'metodo_pagamento' => 'nullable',
        ];
        $customMessages = [
            'nome.required' => "E' necessario inserire il parametro 'Nome'",
            'nome.max' => "Il numero massimo di caratteri consentito per 'Nome' è 255",
            'cognome.required' => "E' necessario inserire il parametro 'Cognome'",
            'cognome.max' => "Il numero massimo di caratteri consentito per 'Cognome' è 255",
            'data_nascita.date' => "E' necessario inserire una data per il campo 'Data di nascita'",
            'luogo_nascita.max' => "Il numero massimo di caratteri consentito per 'Luogo di nascita' è 255",
            'indirizzo.max' => "Il numero massimo di caratteri consentito per 'Indirizzo' è 255",
            'telefono.min' => "Il numero minimo di caratteri consentito per 'Telefono' è 9",
            'telefono.max' => "Il numero massimo di caratteri consentito per 'Telefono' è 10",
            'email.required' => "E' necessario inserire il parametro 'Email'",
            'email.email' => "Formato email errato",
            'email.unique' => "Il valore inserito in 'Email' esiste già",
        ];
        $this->validate($request, $rules, $customMessages);
    }

    private function salva_cliente(Request $request, $cliente, $user)
    {
        $this->salva_utente($request, $user);
        $cliente->user_id = $user->id;
        $cliente->metodo_pagamento = $request->input('metodo_pagamento');
        $cliente->save();
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
