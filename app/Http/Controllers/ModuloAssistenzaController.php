<?php

namespace App\Http\Controllers;

use App\ModuloAssistenza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ModuloAssistenzaController extends Controller
{
    public function __construct()
    {
        $this->middleware('clienti');
    }

    public function index()
    {
        return view('moduli_assistenza.index');
    }

    public function create()
    {
        $data = [
            'assistenza_tipologia_enum' => Enums::assistenza_tipologia_enum(),
        ];
        return view('moduli_assistenza.create', $data);
    }

    public function invia(Request $request)
    {
        $richiesta = $this->salva_richiesta($request);
        return $richiesta ? response()->json(true) : response()->json(false);
    }

    public function show($id)
    {
        $data = [
            'assistenza' => ModuloAssistenza::find($id),
        ];
        return view('moduli_assistenza.show', $data);
    }

    public function table()
    {
        $richieste = ModuloAssistenza::where('cliente_user_id', Auth::user()->id)->get();
        return DataTables::of($richieste)->make(true);
    }

    private function salva_richiesta(Request $request)
    {
        $assistenza = new ModuloAssistenza;
        $assistenza->cliente_user_id = Auth::user()->id;
        $assistenza->tipologia = $request->tipologia;
        $assistenza->oggetto = $request->oggetto;
        $assistenza->messaggio = $request->messaggio;
        $assistenza->save();
        return $assistenza;
    }
}
