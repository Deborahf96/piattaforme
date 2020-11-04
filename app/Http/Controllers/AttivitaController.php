<?php

namespace App\Http\Controllers;

use App\Attivita;
use App\DittaEsterna;
use Illuminate\Http\Request;

class AttivitaController extends Controller
{
    public function __construct()
    {
        $this->middleware('dipendenti');
    }

    public function index(Request $request)
    {
        $tipologia_corrente = $request->input('tipologia');
        $attivita = Attivita::when(isset($tipologia_corrente), function ($query) use ($tipologia_corrente) {
                            return $query->where('tipologia', $tipologia_corrente);
                            })->get();
        $data = [
            'attivita' => $attivita,
            'attivita_tipologia_enum' => Enums::attivita_tipologia_enum(),
            'tipologia_corrente' => $tipologia_corrente
        ];
        return view('attivita.index', $data);
    }

    public function create()
    {
        $data = [
            'attivita_tipologia_enum' => Enums::attivita_tipologia_enum(),
            'ditte_esterne' => DittaEsterna::where('categoria', '=', 'Servizio navetta')
                                            ->orwhere('categoria', '=', 'Tour operator')
                                            ->get()->pluck("nome", "partita_iva")->sort(),

        ];
        return view('attivita.create', $data);
    }

    public function store(Request $request)
    {
        $attivita = new Attivita;
        $this->valida_richiesta($request, $attivita->id);
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
            'attivita' => $attivita,
            'attivita_tipologia_enum' => Enums::attivita_tipologia_enum(),
            'ditte_esterne' => DittaEsterna::where('categoria', '=', 'Servizio navetta')
                                            ->orwhere('categoria', '=', 'Tour operator')
                                            ->get()->pluck("nome", "partita_iva")->sort(),
        ];
        return view('attivita.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $attivita = Attivita::find($id);
        $this->valida_richiesta($request, $id);
        $this->salva_attivita($request, $attivita);
        return redirect('/attivita')->with('success', 'Attività modificata con successo');
    }

    public function destroy($id)
    {
        $attivita = Attivita::find($id);
        $attivita->delete();
        return redirect('/attivita')->with('success', 'Attività eliminata con successo');
    }

    private function valida_richiesta(Request $request, $id)
    {
        $rules = [
            'ditta_esterna_partita_iva' => 'required|unique_ditta_data_ora:' . $request->data . ',' . $request->ora . ',' . $id,
            'data' => 'required|date|current_date_greater_than:',
            'ora' => 'required|date_format:"H:i"',
            'destinazione' => 'required|max:255',
            'costo' => 'required|numeric|gt:0',
        ];
        $customMessages = [
            'ditta_esterna_partita_iva.required' => "E' necessario inserire il parametro 'Ditta esterna'",
            'data.required' => "E' necessario inserire il parametro 'Data'",
            'data.date' => "E' necessario inserire una data per il campo 'Data'",
            'ora.required' => "E' necessario inserire il parametro 'Ora'",
            'ora.date_format' => "Il formato di 'Ora' non è valido. Formato richiesto: hh:mm",
            'destinazione.required' => "E' necessario inserire il parametro 'Luogo di destinazione'",
            'destinazione.max' => "Il numero massimo di caratteri consentito per 'Luogo di destinazione' è 255",
            'costo.required' => "E' necessario inserire il parametro 'Costo'",
            'costo.numeric' => "Il campo 'Costo' può contenere solo numeri",
            'costo.gt' => "Il campo 'Costo' deve essere maggiore di zero",
        ];
        $this->validate($request, $rules, $customMessages);
    }

    private function salva_attivita(Request $request, $attivita)
    {
        $attivita->ditta_esterna_partita_iva = $request->input('ditta_esterna_partita_iva');
        $attivita->data = $request->input('data');
        $attivita->ora = $request->input('ora');
        $attivita->destinazione = $request->input('destinazione');
        $attivita->costo = $request->input('costo');
        $attivita->tipologia = $attivita->ditta_esterna->categoria == "Tour operator" ? 
                                'Visita guidata' : $attivita->ditta_esterna->categoria;
        $attivita->save();
    }
}
