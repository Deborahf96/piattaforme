<?php

namespace App\Http\Controllers;

use App\ModuloAssistenza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuloAssistenzaController extends Controller
{
    public function __construct()
    {
        $this->middleware('clienti');
    }

    public function index()
    {
        $data = [
            'moduli_assistenza' => ModuloAssistenza::where('cliente_user_id', Auth::user()->id)->get()
        ];
        return view('moduli_assistenza.index', $data);
    }

    public function create()
    {
        $data = [
            'assistenza_tipologia_enum' => Enums::assistenza_tipologia_enum(),
        ];
        return view('moduli_assistenza.create', $data);
    }

    public function store(Request $request)
    {
        $this->valida_richiesta($request);
        $this->salva_richiesta($request, new ModuloAssistenza, Auth::user()->id);
        return redirect('/moduli_assistenza')->with('success', 'Richiesta inviata con successo');
    }

    public function show($id)
    {
        $data = [
            'assistenza' => ModuloAssistenza::find($id),
        ];
        return view('moduli_assistenza.show', $data);
    }

    private function valida_richiesta(Request $request)
    {
        $rules = [
            'tipologia' => 'required',
            'oggetto' => 'required|max:255',
            'messaggio' => 'required|max:65535'
        ];
        $customMessages = [
            'tipologia.required' => "E' necessario inserire il parametro 'Tipologia di assistenza'",
            'oggetto.required' => "E' necessario inserire il parametro 'Oggetto'",
            'oggetto.max' => "Il numero massimo di caratteri consentito per 'Oggetto' è 255",
            'messaggio.required' => "E' necessario inserire il parametro 'Messaggio'",
            'messaggio.max' => "Il numero massimo di caratteri consentito per 'Messaggio' è 65535",
        ];
        $this->validate($request, $rules, $customMessages);
    }

    private function salva_richiesta(Request $request, $assistenza, $user_id)
    {
        $assistenza->cliente_user_id = $user_id;
        $assistenza->tipologia = $request->tipologia;
        $assistenza->oggetto = $request->oggetto;
        $assistenza->messaggio = $request->messaggio;
        $assistenza->save();
        return $assistenza;
    }
}
