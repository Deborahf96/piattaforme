<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;

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

}
