<?php

namespace App\Http\Controllers;

use App\Camera;
use App\Dipendente;
use App\Prenotazione;
use Carbon\Carbon;
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
        $dipendente = Dipendente::where('user_id', auth()->user()->id)->first();
        $prenotazione = Prenotazione::where('camera_numero', $camera->numero)  
                                    ->where('data_checkin', '<=', Carbon::now())
                                    ->where('data_checkout', '>', Carbon::now())
                                    ->first(); 

        $data = [
            'camera' => $camera,
            'pren_camera_num' => $prenotazione == null ? false : true,
            'prenotazione_id' => $prenotazione == null ? ' ' : $prenotazione->id,
            'dipendente_check' => $dipendente == null ? false : true
        ];
        return view('camere.show', $data);
    }

    public function edit($numero)
    {
        $camera = Camera::where('numero', $numero)->first();
        $data = [
            'camera' => $camera,
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
            'numero_letti' => 'required|numeric',
            'costo_a_notte' => 'required|numeric',
            'piano' => 'required',
            'descrizione' => 'required|max:255',
        ];
        $customMessages = [
            'numero.required' => "E' necessario inserire il parametro 'Numero'",
            'numero.numeric' => "Il campo 'Numero' deve contenere solo numeri",
            'numero_letti.required' => "E' necessario inserire il parametro 'Numero letti'",
            'numero_letti.numeric' => "Il campo 'Numero letti' deve contenere solo numeri",
            'costo_a_notte.required' => "E' necessario inserire il parametro 'Costo a notte'",
            'costo_a_notte.numeric' => "Il campo 'Costo a notte' deve contenere solo numeri",
            'piano.required' => "E' necessario inserire il parametro 'Piano'",
            'descrizione.required' => "E' necessario inserire il parametro 'Descrizione'",
            'descrizione.max' => "Il numero massimo di caratteri consentito per 'Descrizione' è 255",
        ];
        $this->validate($request, $rules, $customMessages);
    }

    private function valida_richiesta_store(Request $request)
    {
        $rules = [
            'numero' => 'required|numeric|unique:camera',
            'numero_letti' => 'required|numeric',
            'costo_a_notte' => 'required|numeric',
            'piano' => 'required',
            'descrizione' => 'required|max:255',
        ];
        $customMessages = [
            'numero.required' => "E' necessario inserire il parametro 'Numero'",
            'numero.numeric' => "Il campo 'Numero' deve contenere solo numeri",
            'numero.unique' => "Il valore inserito nel parametro 'Numero' esiste già",
            'numero_letti.required' => "E' necessario inserire il parametro 'Numero letti'",
            'numero_letti.numeric' => "Il campo 'Numero letti' deve contenere solo numeri",
            'costo_a_notte.required' => "E' necessario inserire il parametro 'Costo a notte'",
            'costo_a_notte.numeric' => "Il campo 'Costo a notte' deve contenere solo numeri",
            'piano.required' => "E' necessario inserire il parametro 'Piano'",
            'descrizione.required' => "E' necessario inserire il parametro 'Descrizione'",
            'descrizione.max' => "Il numero massimo di caratteri consentito per 'Descrizione' è 255",
        ];
        $this->validate($request, $rules, $customMessages);
    }

    private function salva_camera(Request $request, $camera)
    {
        $camera->numero = $request->input('numero');
        $camera->numero_letti = $request->input('numero_letti');
        $camera->costo_a_notte = $request->input('costo_a_notte');
        $camera->piano = $request->input('piano');
        $camera->descrizione = $request->input('descrizione');
        $camera->save();
    }
}
