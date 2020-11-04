<?php

namespace App\Http\Controllers;

use App\DittaEsterna;
use Illuminate\Http\Request;

class DittaEsternaController extends Controller
{
    public function __construct()
    {
        $this->middleware('dipendenti');
    }

    public function index(Request $request)
    {
        $categoria_corrente = $request->input('categoria');
        $ditte_esterne = DittaEsterna::when(isset($categoria_corrente), function ($query) use ($categoria_corrente) {
                                    return $query->where('categoria', $categoria_corrente);
                                    })->get(); 
        $data = [
            'ditte_esterne' => $ditte_esterne,
            'ditta_esterna_categoria_enum' => Enums::ditta_esterna_categoria_enum(),
            'categoria_corrente' => $categoria_corrente
        ];
        return view('ditte_esterne.index', $data);
    }

    public function create()
    {
        $data = [
            'ditta_esterna_categoria_enum' => Enums::ditta_esterna_categoria_enum(),
            'ditta_esterna_tipo_contratto_enum' => Enums::tipo_contratto_enum(),
        ];
        return view('ditte_esterne.create', $data);
    }

    public function store(Request $request)
    {
        $ditta_esterna = new DittaEsterna;  
        $this->valida_richiesta_store($request);      
        $this->salva_ditta($request, $ditta_esterna);           
        return redirect('/ditte_esterne')->with('success', 'Ditta inserita con successo');
    }

    public function show($partita_iva)
    {
        $ditta_esterna = DittaEsterna::where('partita_iva', $partita_iva)->first();
        $data = [
            'ditta_esterna' => $ditta_esterna
        ];
        return view('ditte_esterne.show', $data);
    }

    public function edit($partita_iva)
    {
        $ditta_esterna = DittaEsterna::where('partita_iva', $partita_iva)->first();
        $data = [
            'ditta_esterna' => $ditta_esterna,
            'ditta_esterna_categoria_enum' => Enums::ditta_esterna_categoria_enum(),
            'ditta_esterna_tipo_contratto_enum' => Enums::tipo_contratto_enum(),
        ];
        return view('ditte_esterne.edit', $data);
    }

    public function update(Request $request, $partita_iva)
    {
        $ditta_esterna = DittaEsterna::where('partita_iva', $partita_iva)->first();
        $this->valida_richiesta_update($request);     
        $this->salva_ditta($request, $ditta_esterna);           
        return redirect('/ditte_esterne')->with('success', 'Ditta modificata con successo');
    }

    public function destroy($partita_iva)
    {
        $ditta_esterna = DittaEsterna::where('partita_iva', $partita_iva)->first();
        $ditta_esterna->delete();
        return redirect('/ditte_esterne')->with('success', 'Ditta eliminata con successo');
    }

    private function valida_richiesta_store(Request $request)
    {
        $rules = [                              
            'partita_iva' => 'required|min:11|max:11|unique:ditta_esterna',    
            'nome' => 'required|max:255',
            'indirizzo' => 'required|max:255',
            'telefono' => 'required|min:9|max:10',
            'email' => 'required|email',
            'descrizione' => 'nullable|max:255',
            'iban' => 'required|min:27|max:27',
            'categoria' => 'required',
            'tipo_contratto' => 'required',
            'paga' => 'required|max:255',
            'data_inizio' => 'required|date',
            'data_fine' => 'nullable|date|date_greater_than:' . $request->data_inizio,
        ];
        $customMessages = [
            'partita_iva.required' => "E' necessario inserire il parametro 'Partita IVA'",
            'partita_iva.min' => "Il numero minimo di caratteri consentito per 'Partita IVA' è 11",
            'partita_iva.max' => "Il numero massimo di caratteri consentito per 'Partita IVA' è 11",
            'partita_iva.unique' => "Il valore inserito in 'Partita IVA' esiste già",
            'nome.required' => "E' necessario inserire il parametro 'Nome'",
            'nome.max' => "Il numero massimo di caratteri consentito per 'Nome' è 255",
            'indirizzo.required' => "E' necessario inserire il parametro 'Indirizzo'",
            'indirizzo.max' => "Il numero massimo di caratteri consentito per 'Indirizzo' è 255",
            'telefono.required' => "E' necessario inserire il parametro 'Telefono'",
            'telefono.min' => "Il numero minimo di caratteri consentito per 'Telefono' è 9",
            'telefono.max' => "Il numero massimo di caratteri consentito per 'Telefono' è 10",
            'email.required' => "E' necessario inserire il parametro 'Email'",
            'email.email' => "Formato email errato",
            'descrizione.max' => "Il numero massimo di caratteri consentito per 'Descrizione' è 255",
            'iban.required' => "E' necessario inserire il parametro 'IBAN'",
            'iban.min' => "Il numero minimo di caratteri consentito per 'IBAN' è 27",
            'iban.max' => "Il numero massimo di caratteri consentito per 'IBAN' è 27",
            'categoria.required' => "E' necessario inserire il parametro 'Categoria'",
            'tipo_contratto.required' => "E' necessario inserire il parametro 'Tipo contratto'",
            'paga.required' => "E' necessario inserire il parametro 'Paga'",
            'paga.max' => "Il numero massimo di caratteri consentito per 'Paga' è 255",
            'data_inizio.required' => "E' necessario inserire il parametro 'Data inizio'",
            'data_inizio.date' => "E' necessario inserire una data per il campo 'Data inizio'",
            'data_fine.date' => "E' necessario inserire una data per il campo 'Data fine'",
        ];
        $this->validate($request, $rules, $customMessages);   
    }

    private function valida_richiesta_update(Request $request)
    {
        $rules = [                             
            'partita_iva' => 'required|min:11|max:11', 
            'nome' => 'required|max:255',
            'indirizzo' => 'required|max:255',
            'telefono' => 'required|min:9|max:10',
            'email' => 'required|email',
            'descrizione' => 'nullable|max:255',
            'iban' => 'required|min:27|max:27',
            'categoria' => 'required',
            'tipo_contratto' => 'required',
            'paga' => 'required|max:255',
            'data_inizio' => 'required|date',
            'data_fine' => 'nullable|date|date_greater_than:' . $request->data_inizio,
        ];
        $customMessages = [
            'partita_iva.required' => "E' necessario inserire il parametro 'Partita IVA'",
            'partita_iva.min' => "Il numero minimo di caratteri consentito per 'Partita IVA' è 11",
            'partita_iva.max' => "Il numero massimo di caratteri consentito per 'Partita IVA' è 11",
            'nome.required' => "E' necessario inserire il parametro 'Nome'",
            'nome.max' => "Il numero massimo di caratteri consentito per 'Nome' è 255",
            'indirizzo.required' => "E' necessario inserire il parametro 'Indirizzo'",
            'indirizzo.max' => "Il numero massimo di caratteri consentito per 'Indirizzo' è 255",
            'telefono.required' => "E' necessario inserire il parametro 'Telefono'",
            'telefono.min' => "Il numero minimo di caratteri consentito per 'Telefono' è 9",
            'telefono.max' => "Il numero massimo di caratteri consentito per 'Telefono' è 10",            
            'email.required' => "E' necessario inserire il parametro 'Email'",
            'email.email' => "Formato email errato",
            'descrizione.max' => "Il numero massimo di caratteri consentito per 'Descrizione' è 255",
            'iban.required' => "E' necessario inserire il parametro 'IBAN'",
            'iban.min' => "Il numero minimo di caratteri consentito per 'IBAN' è 27",
            'iban.max' => "Il numero massimo di caratteri consentito per 'IBAN' è 27",
            'categoria.required' => "E' necessario inserire il parametro 'Categoria'",
            'tipo_contratto.required' => "E' necessario inserire il parametro 'Tipo contratto'",
            'paga.required' => "E' necessario inserire il parametro 'Paga'",
            'paga.max' => "Il numero massimo di caratteri consentito per 'Paga' è 255",
            'data_inizio.required' => "E' necessario inserire il parametro 'Data inizio'",
            'data_inizio.date' => "E' necessario inserire una data per il campo 'Data inizio'",
            'data_fine.date' => "E' necessario inserire una data per il campo 'Data fine'",
        ];
        $this->validate($request, $rules, $customMessages);   
    }

    private function salva_ditta(Request $request, $ditta_esterna)             
    {
        $ditta_esterna->partita_iva = $request->input('partita_iva');          
        $ditta_esterna->nome = $request->input('nome');
        $ditta_esterna->indirizzo = $request->input('indirizzo');
        $ditta_esterna->telefono = $request->input('telefono');
        $ditta_esterna->email = $request->input('email');
        $ditta_esterna->descrizione = $request->input('descrizione');
        $ditta_esterna->iban = $request->input('iban');
        $ditta_esterna->categoria = $request->input('categoria');
        $ditta_esterna->tipo_contratto = $request->input('tipo_contratto');
        $ditta_esterna->paga = $request->input('paga');
        $ditta_esterna->data_inizio = $request->input('data_inizio');
        $ditta_esterna->data_fine = $request->input('data_fine');
        $ditta_esterna->save();                                               
    }
}
