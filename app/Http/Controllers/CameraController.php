<?php

namespace App\Http\Controllers;

use App\Camera;
use App\Dipendente;
use App\Prenotazione;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CameraController extends Controller
{
    public function __construct()
    {
        $this->middleware('dipendenti', ['except' => ['show']]);
    }

    public function index()
    {
        $camere = Camera::all();
        $data = [
            'camere' => $camere
        ];
        return view('camere.index', $data);
    }

    public function aggiungi()
    {
        $data = [
            'camera_piano_enum' => Enums::camera_piano_enum()
        ];
        return view('camere.create', $data);
    }

    public function aggiungiCamera(Request $request)
    {
        if(Camera::where('numero', $request->numero)->exists())
            return 'Errore! Camera n°'.$request->numero.' già presente';
        $this->valida_richiesta_camera($request);
        $camera = $this->salva_camera($request);
        return $camera ? response()->json(true) : response()->json(false);
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

    public function caricaImmagine(Request $request)
    {
        $validazione = $this->valida_richiesta_immagine($request);
        if($validazione){
            $image_name = $this->salva_immagine($request);
            if($image_name){
                return response()->json([
                    'message' => 'Immagine caricata con successo!',
                    'class_name' => 'alert-success',
                    'image_name' => $image_name
                ]);
            }
        }
        return response()->json([
            'message' => "Errore nel caricamento dell'immagine! Controlla che l'estensione sia corretta (jpeg, png, jpg, gif, svg) e che la dimensione non superi i 2Mb.",
            'class_name' => 'alert-danger',
            'image_name' => null
        ]);
    }

    private function valida_richiesta_update(Request $request)
    {
        $rules = [
            'numero' => 'required|numeric|gt:0',
            'numero_letti' => 'required|numeric|gt:0',
            'costo_a_notte' => 'required|numeric|gt:0',
            'piano' => 'required',
            'descrizione' => 'required|max:65535',
        ];
        $customMessages = [
            'numero.required' => "E' necessario inserire il parametro 'Numero'",
            'numero.numeric' => "Il campo 'Numero' deve contenere solo numeri",
            'numero.gt' => "Il campo 'Numero' deve essere maggiore di zero",
            'numero_letti.required' => "E' necessario inserire il parametro 'Posti letto'",
            'numero_letti.numeric' => "Il campo 'Posti letto' deve contenere solo numeri",
            'numero_letti.gt' => "Il campo 'Posti letto' deve essere maggiore di zero",
            'costo_a_notte.required' => "E' necessario inserire il parametro 'Costo a notte'",
            'costo_a_notte.numeric' => "Il campo 'Costo a notte' deve contenere solo numeri",
            'costo_a_notte.gt' => "Il campo 'Costo a notte' deve essere maggiore di zero",
            'piano.required' => "E' necessario inserire il parametro 'Piano'",
            'descrizione.required' => "E' necessario inserire il parametro 'Descrizione'",
            'descrizione.max' => "Il numero massimo di caratteri consentito per 'Descrizione' è 65535",
        ];
        $this->validate($request, $rules, $customMessages);
    }

    private function valida_richiesta_camera(Request $request)
    {
        $rules = [
            'numero' => 'required|numeric|gt:0|unique:camera',
            'numero_letti' => 'required|numeric|gt:0',
            'costo_a_notte' => 'required|numeric|gt:0',
            'piano' => 'required',
            'descrizione' => 'required|max:65535',
        ];
        $customMessages = [
            'numero.required' => "E' necessario inserire il parametro 'Numero'",
            'numero.numeric' => "Il campo 'Numero' deve contenere solo numeri",
            'numero.gt' => "Il campo 'Numero' deve essere maggiore di zero",
            'numero.unique' => "Il valore inserito nel parametro 'Numero' esiste già",
            'numero_letti.required' => "E' necessario inserire il parametro 'Posti letto'",
            'numero_letti.numeric' => "Il campo 'Posti letto' deve contenere solo numeri",
            'numero_letti.gt' => "Il campo 'Posti letto' deve essere maggiore di zero",
            'costo_a_notte.required' => "E' necessario inserire il parametro 'Costo a notte'",
            'costo_a_notte.numeric' => "Il campo 'Costo a notte' deve contenere solo numeri",
            'costo_a_notte.gt' => "Il campo 'Costo a notte' deve essere maggiore di zero",
            'piano.required' => "E' necessario inserire il parametro 'Piano'",
            'descrizione.required' => "E' necessario inserire il parametro 'Descrizione'",
            'descrizione.max' => "Il numero massimo di caratteri consentito per 'Descrizione' è 65535",
        ];
        $this->validate($request, $rules, $customMessages);
    }

    private function valida_richiesta_immagine(Request $request)
    {
        $rules = [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        $customMessages = [
        ];
        return $this->validate($request, $rules, $customMessages);
    }

    private function salva_camera(Request $request)
    {
        $camera = new Camera;
        $camera->numero = $request->numero;
        $camera->numero_letti = $request->numero_letti;
        $camera->costo_a_notte = $request->costo_a_notte;
        $camera->piano = $request->piano;
        $camera->descrizione = $request->descrizione;
        $camera->path_foto = $request->path_foto ? $request->path_foto : '';
        $camera->save();
        return $camera;
    }

    private function salva_immagine(Request $request)
    {
        $image_name = $request->image->getClientOriginalName();
        $request->image->move(public_path('img/camere'), $image_name);
        return $image_name;
    }
}
