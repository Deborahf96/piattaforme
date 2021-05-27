<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClienteClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('clienti');
    }

    public function show() 
    {
        $cliente = Cliente::where('user_id', Auth::user()->id)->first();
        $data = [
            'cliente' => $cliente
        ];
        return view('clienti.show', $data);
    }

    public function edit()
    {
        $cliente = Cliente::where('user_id', Auth::user()->id)->first();
        $data = [
            'cliente' => $cliente,
            'cliente_metodo_pagamento_enum' => Enums::metodo_pagamento_enum(),
        ];
        return view('clienti.edit', $data);
    }

    public function modifica(Request $request)
    {
        if(User::where('id', '!=', $request->user_id)->where('email', $request->email)->exists())
            return 'Attenzione! Email ('.$request->email.') già registrata';
        DB::beginTransaction();
        try{
            $this->salva_utente($request);
            $this->salva_cliente($request);
            DB::commit();
        } catch(Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
        return response()->json(true);
    }

    public function elimina()
    {
        DB::beginTransaction();
        try{
            $user_id = Auth::user()->id;
            Cliente::where('user_id', $user_id)->first()->delete();
            User::find($user_id)->delete();
            Auth::logout();
            DB::commit();
        } catch(Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 400);
        }
        return response()->json(true, 200);
    }

    private function salva_cliente(Request $request)
    {
        $cliente = Cliente::where('user_id', $request->user_id)->first();
        $cliente->metodo_pagamento = $request->metodo_pagamento;
        $cliente->save();
        return $cliente;
    }

    private function salva_utente(Request $request)
    {
        $user = User::find($request->user_id);
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
}
