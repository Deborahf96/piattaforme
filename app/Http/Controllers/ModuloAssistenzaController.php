<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\ModuloAssistenza;
use Illuminate\Http\Request;

class ModuloAssistenzaController extends Controller
{
   
    public function create()
    {
        $data = [
            'tipo_assistenza_enum' => Enums::tipo_assistenza_enum(),
            'clienti' => Cliente::all()->pluck("utente.name", "user_id")->sort(),
        ];
        return view('modulo_assistenza.create', $data);
    }

    public function store(Request $request)
    {
        $assistenza = new ModuloAssistenza();
        $this->valida_richiesta($request, $assistenza->id);
        $this->salva_richiesta($request, $assistenza);
        return redirect('/modulo_assistenza')->with('success','Richiesta inviata con successo');
    //forse mettere /modulo_assistenza/create
    }

    public function show($id)
    {
        //
    }

    private function valida_richiesta(Request $request, $id)
    {
        $rules = [
            'cliente_user_id' => 'nullable',
            'tipologia' => 'required'     
        ];
        $customMessages = [
            'tipologia.required' => "E' necessario inserire il tipo di assistenza'",
        ];

        $this->validate($request, $rules, $customMessages);
    }

    private function salva_richiesta(Request $request, $assistenza)
    {
        $assistenza->cliente_user_id = $request->input('cliente_user_id');
        $assistenza->tipologia = $request->input('tipologia');
        $assistenza->data = date('m/d/Y h:i:s a', time());
        $assistenza->ora = time();
        $assistenza->save();
    }

}
