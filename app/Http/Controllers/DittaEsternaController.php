<?php

namespace App\Http\Controllers;

use App\DittaEsterna;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DittaEsternaController extends Controller
{
    public function __construct()
    {
        $this->middleware('dipendenti');
    }

    public function index()
    {
        return view('ditte_esterne.index');
    }

    public function create()
    {
        $data = [
            'ditta_esterna_categoria_enum' => Enums::ditta_esterna_categoria_enum(),
            'ditta_esterna_tipo_contratto_enum' => Enums::tipo_contratto_enum(),
        ];
        return view('ditte_esterne.create', $data);
    }

    public function aggiungiDitta(Request $request)
    {
        if(DittaEsterna::where('partita_iva', $request->partita_iva)->exists())
            return 'Attenzione! Partita IVA '.$request->partita_iva.' già registrata';
        if($request->data_fine != null && Carbon::parse($request->data_inizio)->greaterThanOrEqualTo(Carbon::parse($request->data_fine)))
            return "La data di fine deve essere maggiore della data di inizio";
        $ditta_salvata = $this->salva_ditta($request, new DittaEsterna);           
        return $ditta_salvata ? response()->json(true) : response()->json(false);
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

    public function modificaDitta(Request $request)
    {
        if(DittaEsterna::where('id', '!=', $request->id)->where('partita_iva', $request->partita_iva)->exists())
            return 'Errore! Partita IVA '.$request->partita_iva.' già registrata';
        if(Carbon::parse($request->data_inizio)->greaterThanOrEqualTo(Carbon::parse($request->data_fine)))
            return "La data di fine deve essere maggiore della data di inizio";
        $ditta_esterna = DittaEsterna::find($request->id);
        $ditta_salvata = $this->salva_ditta($request, $ditta_esterna);           
        return $ditta_salvata ? response()->json(true) : response()->json(false);
    }

    public function elimina(Request $request)
    {
        $ditta_esterna = DittaEsterna::find($request->input('id'))->delete();
        return $ditta_esterna ? response()->json(true,200) : response()->json(false, 400);
    }

    public function tableDitte()
    {
        $ditte_esterne = DittaEsterna::all();
        return DataTables::of($ditte_esterne)->make(true);
    }

    private function salva_ditta(Request $request, $ditta_esterna)             
    {
        $ditta_esterna->partita_iva = $request->partita_iva;          
        $ditta_esterna->nome = $request->nome;
        $ditta_esterna->indirizzo = $request->indirizzo;
        $ditta_esterna->telefono = $request->telefono;
        $ditta_esterna->email = $request->email;
        $ditta_esterna->descrizione = $request->descrizione;
        $ditta_esterna->iban = $request->iban;
        $ditta_esterna->categoria = $request->categoria;
        $ditta_esterna->tipo_contratto = $request->tipo_contratto;
        $ditta_esterna->paga = $request->paga;
        $ditta_esterna->data_inizio = $request->data_inizio;
        $ditta_esterna->data_fine = $request->data_fine;
        $ditta_esterna->save();
        return $ditta_esterna;                                             
    }
}
