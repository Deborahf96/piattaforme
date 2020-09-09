<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\ModuloAssistenza;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuloAssistenzaController extends Controller
{

    public function index() 
    {
        $user_id = Auth::user()->id;
        $data = [
            'moduli_assistenza' => ModuloAssistenza::where('cliente_user_id', $user_id)->get()
        ];
        return view('moduli_assistenza.index',$data);
    }
   
    public function create()
    {
        $data = [
            'tipo_assistenza_enum' => Enums::tipo_assistenza_enum(),
        ];
        return view('moduli_assistenza.create', $data);
    }

    public function store(Request $request)
    {
        $assistenza = new ModuloAssistenza();
        $user_id = Auth::user()->id;
        $this->valida_richiesta($request, $assistenza->id);
        $this->salva_richiesta($request, $assistenza, $user_id);
        return redirect('/moduli_assistenza')->with('success','Richiesta inviata con successo');
    //forse mettere /modulo_assistenza/create
    }

    public function show($id)
    {
        //
    }

    private function valida_richiesta(Request $request, $id)
    {
        $rules = [
            'tipologia' => 'required',   
            'messaggio' => 'required'
        ];
        $customMessages = [
            'tipologia.required' => "E' necessario inserire il tipo di assistenza'",
        ];

        $this->validate($request, $rules, $customMessages);
    }

    private function salva_richiesta(Request $request, $assistenza, $user_id)
    {
        $assistenza->cliente_user_id = $user_id;
        $assistenza->tipologia = $request->input('tipologia');
        $assistenza->messaggio = $request->input('messaggio');
        $assistenza->save();
    }

}
