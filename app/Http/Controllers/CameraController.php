<?php

namespace App\Http\Controllers;

use App\Camera;
use App\Dipendente;
use App\Prenotazione;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CameraController extends Controller
{
    public function __construct()
    {
        $this->middleware('dipendenti', ['except' => ['show']]);
    }

    public function index()
    {
        return view('camere.index');
    }

    public function create()
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
        $camera_salvata = $this->salva_camera($request, new Camera);
        return $camera_salvata ? response()->json(true) : response()->json(false);
    }

    public function show($id)
    {
        $dipendente = Dipendente::where('user_id', auth()->user()->id)->first();
        $prenotazione = Prenotazione::where('camera_id', $id)  
                                    ->where('data_checkin', '<=', Carbon::now())
                                    ->where('data_checkout', '>', Carbon::now())
                                    ->first(); 

        $data = [
            'camera' => Camera::find($id),
            'pren_camera_num' => $prenotazione == null ? false : true,
            'prenotazione_id' => $prenotazione == null ? ' ' : $prenotazione->id,
            'dipendente_check' => $dipendente == null ? false : true
        ];
        return view('camere.show', $data);
    }

    public function edit($id)
    {
        $data = [
            'camera' => Camera::find($id),
            'camera_piano_enum' => Enums::camera_piano_enum(),
        ];
        return view('camere.edit', $data);
    }

    public function modificaCamera(Request $request)
    {
        if(Camera::where('id', '!=', $request->id)->where('numero', $request->numero)->exists())
            return 'Errore! Camera n°'.$request->numero.' già presente';
        $camera_salvata = $this->salva_camera($request, Camera::find($request->id));
        return $camera_salvata ? response()->json(true) : response()->json(false);
    }

    public function elimina(Request $request)
    {
        $camera = Camera::find($request->input('id'))->delete();
        return $camera ? response()->json(true,200) : response()->json(false, 400);
    }

    public function caricaImmagine(Request $request)
    {
        $validazione = $this->valida_richiesta_immagine($request);
        if(!$validazione->fails()) {
            $image_name = $this->salva_immagine($request);
            if($image_name)
                return response()->json([
                    'message' => 'Immagine caricata con successo!',
                    'class_name' => 'alert-success',
                    'image_name' => $image_name
                ]);
        }
        return response()->json([
            'message' => "Errore nel caricamento dell'immagine! Controlla che l'estensione sia corretta (jpeg, png, jpg, gif, svg) e che la dimensione non superi i 2Mb.",
            'class_name' => 'alert-danger',
            'image_name' => null
        ]);
    }

    public function tableCamere()
    {
        $camere = Camera::all();
        return DataTables::of($camere)->make(true);
    }

    private function salva_camera(Request $request, $camera)
    {
        $camera->numero = $request->numero;
        $camera->numero_letti = $request->numero_letti;
        $camera->costo_a_notte = $request->costo_a_notte;
        $camera->piano = $request->piano;
        $camera->descrizione = $request->descrizione;
        $camera->path_foto = $request->path_foto;
        $camera->save();
        return $camera;
    }

    private function valida_richiesta_immagine(Request $request)
    {
        $rules = [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        return Validator::make($request->all(), $rules);
    }

    private function salva_immagine(Request $request)
    {
        $image_name = $request->path_foto ? $request->path_foto : rand() . '.png';
        $request->image->move(public_path('img/camere'), $image_name);
        return $image_name;
    }
}
