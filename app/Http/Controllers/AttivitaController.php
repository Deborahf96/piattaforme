<?php

namespace App\Http\Controllers;

use App\Attivita;
use Illuminate\Http\Request;

class AttivitaController extends Controller
{
    public function index()
    {
        $attivita = Attivita::all();
        $data = [
            'attivita' => $attivita
        ];
        return view('attivita.index', $data);
    }

    public function create()
    {
        return view('attivita.create');
    }

    public function store(Request $request)
    {
        $attivita = new Attivita;
        $this->valida_richiesta_store($request);
        $this->salva_attivita($request, $attivita);
        return redirect('/attivita')->with('success', 'Attività inserita con successo');
    }

    public function show($id)
    {
        $attivita = Attivita::find($id);
        $data = [
            'attivita' => $attivita
        ];
        return view('attivita.show', $data);
    }

    public function edit($id)
    {
        $attivita = Attivita::find($id);
        $data = [
            'attivita' => $attivita
        ];
        return view('attivita.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $attivita = Attivita::find($id);
        $this->valida_richiesta_update($request);
        $this->salva_attivita($request, $attivita);
        return redirect('/attivita')->with('success','Attività modificata con successo');
    }

    public function destroy($id)
    {
        $attivita = Attivita::find($id);
        $attivita->delete();
        return redirect('/attivita')->with('success', 'Attività eliminata con successo');
    }

    private function valida_richiesta_update(Request $request)
    {
        $rules = [
            'ditta_esterna' => 'required|max:255',
            'data' => 'required|date',
            'ora' => 'required|datetime',
            'max_persone' => 'required|numeric',
            'destinazione' => 'required|max:255',
            'descrizione' => 'required|max:255',
        ];
        $customMessages = [
            'ditta_esterna.required' => "E' necessario inserire il parametro 'Ditta esterna'",
            'ditta_esterna.max' => "Il numero massimo di caratteri consentito per 'Ditta esterna' è 255",
            'data.required' => "E' necessario inserire il parametro 'Data'",
            'data.date' => "E' necessario inserire una data per il campo 'Data'",
            'ora.required' => "E' necessario inserire il parametro 'Ora'",
            'ora.datetime' => "E' necessario inserire un orario per il campo 'Ora'",
            'max_persone.required' => "E' necessario inserire il parametro 'Numero massimo di partecipanti'",
            'max_persone.numeric' => "Il campo 'Numero massimo di partecipanti' può contenere solo numeri",
            'destinazione.required' => "E' necessario inserire il parametro 'Luogo di destinazione'",
            'destinazione.max' => "Il numero massimo di caratteri consentito per 'Luogo di destinazione' è 255",
            'descrizione.required' => "E' necessario inserire il parametro 'Descrizione'",
            'descrizione.max' => "Il numero massimo di caratteri consentito per 'Descrizione' è 255",
        ];
        $this->validate($request, $rules, $customMessages);
    }

    private function valida_richiesta_store(Request $request)
    {
        $rules = [
            'ditta_esterna' => 'required|max:255', //vedere come fare la unique composta
            'data' => 'required|date',
            'ora' => 'required|datetime',
            'max_persone' => 'required|numeric',
            'destinazione' => 'required|max:255',
            'descrizione' => 'required|max:255',
        ];
        $customMessages = [
            'ditta_esterna.required' => "E' necessario inserire il parametro 'Ditta esterna'",
            'ditta_esterna.max' => "Il numero massimo di caratteri consentito per 'Ditta esterna' è 255",
            'data.required' => "E' necessario inserire il parametro 'Data'",
            'data.date' => "E' necessario inserire una data per il campo 'Data'",
            'ora.required' => "E' necessario inserire il parametro 'Ora'",
            'ora.datetime' => "E' necessario inserire un orario per il campo 'Ora'",
            'max_persone.required' => "E' necessario inserire il parametro 'Numero massimo di partecipanti'",
            'max_persone.numeric' => "Il campo 'Numero massimo di partecipanti' può contenere solo numeri",
            'destinazione.required' => "E' necessario inserire il parametro 'Luogo di destinazione'",
            'destinazione.max' => "Il numero massimo di caratteri consentito per 'Luogo di destinazione' è 255",
            'descrizione.required' => "E' necessario inserire il parametro 'Descrizione'",
            'descrizione.max' => "Il numero massimo di caratteri consentito per 'Descrizione' è 255",
        ];
        $this->validate($request, $rules, $customMessages);
    }

    private function salva_attivita(Request $request, $attivita)
    {
        $attivita->ditta_esterna = $request->input('ditta_esterna');
        $attivita->data = $request->input('data');
        $attivita->ora = $request->input('ora');
        $attivita->max_persone = $request->input('max_persone');
        $attivita->destinazione = $request->input('destinazione');
        $attivita->descrizione = $request->input('descrizione');
        $attivita->save();
    }
}
