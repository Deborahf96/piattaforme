<?php

namespace App\Http\Controllers;

use App\Attivita;
use App\DittaEsterna;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AttivitaController extends Controller
{
    public function __construct()
    {
        $this->middleware('dipendenti');
    }

    public function index()
    {
        return view('attivita.index');
    }

    public function create()
    {
        $data = [
            'attivita_tipologia_enum' => Enums::attivita_tipologia_enum(),
            'ditte_esterne' => DittaEsterna::where('categoria', 'Servizio navetta')
                                            ->orwhere('categoria', 'Tour operator')
                                            ->get()->pluck("ditta", "id")->sort(),
        ];
        return view('attivita.create', $data);
    }

    public function aggiungiAttivita(Request $request)
    {
        if($this->gia_presente($request))
            return "Attenzione! La combinazione di attributi 'Ditta esterna, data, ora' esiste già";
        if(Carbon::now()->greaterThanOrEqualTo(Carbon::parse($request->data)))
            return "La data inserita non è valida. Inserire una data maggiore rispetto alla data odierna";
        $attivita_salvata = $this->salva_attivita($request, new Attivita);
        return $attivita_salvata ? response()->json(true) : response()->json(false);
    }

    public function show($id)
    {
        $data = [
            'attivita' => Attivita::find($id)
        ];
        return view('attivita.show', $data);
    }

    public function edit($id)
    {
        $data = [
            'attivita' => Attivita::find($id),
            'attivita_tipologia_enum' => Enums::attivita_tipologia_enum(),
            'ditte_esterne' => DittaEsterna::where('categoria', '=', 'Servizio navetta')
                                            ->orwhere('categoria', '=', 'Tour operator')
                                            ->get()->pluck("ditta", "id")->sort(),
        ];
        return view('attivita.edit', $data);
    }

    public function modificaAttivita(Request $request)
    {
        if($this->gia_presente_id($request))
            return "Attenzione! La combinazione di attributi 'Ditta esterna, data, ora' esiste già";
        if(Carbon::now()->greaterThanOrEqualTo(Carbon::parse($request->data)))
            return "La data inserita non è valida. Inserire una data maggiore rispetto alla data odierna";
        $attivita_salvata = $this->salva_attivita($request, Attivita::find($request->id));
        return $attivita_salvata ? response()->json(true) : response()->json(false);
    }

    public function elimina(Request $request)
    {
        $attivita = Attivita::find($request->id)->delete();
        return $attivita ? response()->json(true,200) : response()->json(false, 400);
    }

    public function tableAttivita()
    {
        $attivita = $this->recupera_attivita();
        return $this->genera_datatable($attivita);
    }

    private function salva_attivita(Request $request, $attivita)
    {
        $attivita->ditta_esterna_id = $request->ditta_esterna_id;
        $attivita->data = $request->data;
        $attivita->ora = $request->ora;
        $attivita->destinazione = $request->destinazione;
        $attivita->costo = $request->costo;
        $attivita->tipologia = $attivita->ditta_esterna->categoria == "Tour operator" ? 'Visita guidata' : $attivita->ditta_esterna->categoria;
        $attivita->save();
        return $attivita;
    }

    private function gia_presente(Request $request)
    {
        return Attivita::where('ditta_esterna_id', $request->ditta_esterna_id)
            ->where('data', $request->data)
            ->where('ora', $request->ora)
            ->exists();
    }

    private function gia_presente_id(Request $request)
    {
        return Attivita::where('ditta_esterna_id', $request->ditta_esterna_id)
            ->where('data', $request->data)
            ->where('ora', $request->ora)
            ->where('id', '!=', $request->id)
            ->exists();
    }

    private function recupera_attivita()
    {
        return Attivita::join('ditta_esterna', 'attivita.ditta_esterna_id', 'ditta_esterna.id')
            ->select(
                'attivita.id',
                'attivita.tipologia',
                'attivita.data',
                'attivita.destinazione',
                'attivita.costo',
                'ditta_esterna.nome',
                DB::raw('TIME_FORMAT(attivita.ora, "%H:%i") as ora')
            );
    }

    private function genera_datatable($attivita)
    {
        return DataTables::of($attivita)
        ->filterColumn("nome", function ($q, $k) { return $q->whereRaw("ditta_esterna.nome LIKE ?", ["%$k%"]); })
        ->filterColumn("ora", function ($q, $k) { return $q->whereRaw("TIME_FORMAT(attivita.ora, '%H:%i') LIKE ?", ["%$k%"]); })
        ->filterColumn("", function ($q, $k) { return ''; })
        ->filterColumn(null, function ($q, $k) { return ''; })
        ->make(true);
    }
}
