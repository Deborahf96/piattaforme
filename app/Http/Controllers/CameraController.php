<?php

namespace App\Http\Controllers;

use App\Camera;
use Illuminate\Http\Request;

class CameraController extends Controller
{
    public function index()
    {
        $camere = Camera::all();
        $data = [
            'camere' => $camere
        ];
        return view('camere.index', $data);
    }

    public function create()
    {
        $data = [
            'camera_disponibilità_enum' => Enums::camera_disponibilità_enum(),
            'camera_piano_enum' => Enums::camera_piano_enum()
        ];
        return view('camere.create', $data);
    }

    public function store(Request $request)
    {
        $camera = new Camera;
        $this->valida_richiesta_store($request);
        $this->salva_camera($request, $camera);
        return redirect('/camere')->with('success', 'Camera inserita con successo');
    }

    public function show($numero)
    {
        $camera = Camera::where('numero', $numero)->first();
        $data = [
            'camera' => $camera
        ];
        return view('camere.show', $data);
    }

    public function edit($numero)
    {
        $camera = Camera::where('numero', $numero)->first();
        $data = [
            'camera' => $camera,
            'camera_disponibilità_enum' => Enums::camera_disponibilità_enum(),
            'camera_piano_enum' => Enums::camera_piano_enum()
        ];
        return view('camere.edit', $data);
    }

    public function update(Request $request, $numero)
    {
        $camera = Camera::where('numero', $numero)->first();
        $this->valida_richiesta_update($request);
        $this->salva_camera($request, $camera);
        return redirect('/camere')->with('success', 'Camera modificata con successo');
    }

    public function destroy($numero)
    {
        $camera = Camera::where('numero', $numero)->first();
        $camera->delete();
        return redirect('/camere')->with('success', 'Camera eliminata con successo');
    }

    private function valida_richiesta_update(Request $request)
    {
        $rules = [                              
            'numero' => 'required|numeric',
            'disponibilità' => 'required|max:255',
            'numero_letti' => 'required|numeric',
            'piano' => 'required|max:255',
            'descrizione' => 'required|max:255',
        ];
        $customMessages = [
            'numero.required' => "E' necessario inserire il parametro 'Numero'",
            'numero.numeric' => "Il campo 'Numero' deve contenere solo numeri",
            'disponibilità.required' => "E' necessario inserire il parametro 'Disponibilità'",
            'disponibilità.max' => "Il numero massimo di caratteri consentito per 'Disponibilità' è 255",
            'numero_letti.required' => "E' necessario inserire il parametro 'Numero letti'",
            'numero_letti.numeric' => "Il campo 'Numero letti' deve contenere solo numeri",
            'piano.required' => "E' necessario inserire il parametro 'Piano'",
            'piano.max' => "Il numero massimo di caratteri consentito per 'Piano' è 255",
            'descrizione.required' => "E' necessario inserire il parametro 'Descrizione'",
            'descrizione.max' => "Il numero massimo di caratteri consentito per 'Descrizione' è 255",
        ];
        $this->validate($request, $rules, $customMessages);
    }

    private function valida_richiesta_store(Request $request)
    {
        $rules = [                             
            'numero' => 'required|numeric|unique:camera',
            'disponibilità' => 'required|max:255',
            'numero_letti' => 'required|numeric',
            'piano' => 'required|max:255',
            'descrizione' => 'required|max:255',
        ];
        $customMessages = [
            'numero.required' => "E' necessario inserire il parametro 'Numero'",
            'numero.numeric' => "Il campo 'Numero' deve contenere solo numeri",
            'disponibilità.required' => "E' necessario inserire il parametro 'Disponibilità'",
            'disponibilità.max' => "Il numero massimo di caratteri consentito per 'Disponibilità' è 255",
            'numero_letti.required' => "E' necessario inserire il parametro 'Numero letti'",
            'numero_letti.numeric' => "Il campo 'Numero letti' deve contenere solo numeri",
            'piano.required' => "E' necessario inserire il parametro 'Piano'",
            'piano.max' => "Il numero massimo di caratteri consentito per 'Piano' è 255",
            'descrizione.required' => "E' necessario inserire il parametro 'Descrizione'",
            'descrizione.max' => "Il numero massimo di caratteri consentito per 'Descrizione' è 255",
        ];
        $this->validate($request, $rules, $customMessages);
    }

    private function salva_camera(Request $request, $camera)              
    {
        $camera->numero = $request->input('numero');          
        $camera->disponibilità = $request->input('disponibilità');
        $camera->numero_letti = $request->input('numero_letti');
        $camera->piano = $request->input('piano');
        $camera->descrizione = $request->input('descrizione');
        $camera->save();                                                 
    }
}
