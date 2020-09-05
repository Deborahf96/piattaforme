<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clienti = Cliente::all();
        $data = [
            'clienti' => $clienti
        ];
        return view('clienti.index',$data);
    }


   
    public function show($email)
    {
        $cliente = Cliente::where('email', $email)->first();
        $data = [
            'cliente' => $cliente
        ];
        return view('cliente.show', $data);
    }

}
