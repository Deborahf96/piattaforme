<?php

namespace App\Http\Controllers;

use App\Dipendente;
use Illuminate\Http\Request;

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
        $this->valida_richiesta_store($request);
        $this->salva_dipendente($request, $dipendente);
        return redirect('/dipendenti')->with('success', 'Dipendente inserito con successo');
    }

    public function show($email)
    {
        $dipendente = Dipendente::where('email', $email)->first();
        $data = [
            'dipendente' => $dipendente,
        ];
        return view('dipendenti.show', $data);
    }

    public function edit($email)
    {
        $dipendente = Dipendente::where('email', $email)->first();
        $data = [
            'dipendente' => $dipendente,
        ];
        return view('dipendenti.edit', $data);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($email)
    {
        $dipendente = Dipendente::where('email', $email)->first();
        $dipendente->delete();
        return redirect('/dipendenti')->with('success', 'Dipendente eliminato con successo');
    }
}
