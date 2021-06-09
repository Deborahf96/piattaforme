<?php

namespace App\Http\Controllers;

use App\Attivita;
use App\Prenotazione;
use Illuminate\Http\Request;

class PrenotazioneUtil
{
    public static function camere_escluse($data_checkin, $data_checkout, $num_persone){
        return Prenotazione::join('camera', 'prenotazione.camera_id', '=', 'camera.id')
                ->where(function ($query) use ($data_checkin, $data_checkout, $num_persone) {
                    $query->where('camera.numero_letti', '>=', $num_persone)
                        ->where('data_checkout', '>', $data_checkin)
                        ->where(function ($query) use ($data_checkout) {
                            $query->where(function ($query) use ($data_checkout) {
                                $query->where('data_checkin', '<', $data_checkout)->where('data_checkout', '>=', $data_checkout);
                            })->orWhere('data_checkout', '<', $data_checkout);
                        });
                })->orWhere('camera.numero_letti', '<', $num_persone)
                ->get()->pluck('numero');
    }

    public static function valida_campi(Request $request, $controller){
        $rules = [
            'data_checkin' => 'nullable|date|current_date_greater_than_equals',
            'data_checkout' => 'nullable|date|date_greater_than:' . $request->data_checkin,
            'num_persone' => 'nullable|numeric|gt:0',
        ];
        $customMessages = [
            'data_checkin.date' => "E' necessario inserire una data per il campo 'Data checkin'",
            'data_checkout.date' => "E' necessario inserire una data per il campo 'Data checkout'",
            'num_persone.numeric' => "Il campo 'Posti letto' può contenere solo numeri",
            'num_persone.gt' => "Il campo 'Posti letto' deve essere maggiore di zero",
        ];

        $controller->validate($request, $rules, $customMessages);
    }

    public static function salva_attivita($request, $prenotazione)
    {
        if(isset($request->attivita))
            foreach($request->attivita as $singola_attivita_id)
            {
                $attivita = Attivita::find($singola_attivita_id);
                $prenotazione->attivita()->attach($attivita);
                $prenotazione->importo = $prenotazione->importo + $attivita->costo;
                $prenotazione->save();
            }
    }
}