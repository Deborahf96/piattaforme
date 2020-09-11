<?php

namespace App\Http\Controllers;

use App\Attivita;
use App\Prenotazione;
use App\User;
use Illuminate\Http\Request;

class PrenotazioneAttivitaController extends Controller
{
    public function seleziona_attivita($id)
    {
        $prenotazione = Prenotazione::find($id);
        $attivita = Attivita::where('data', '>', $prenotazione->data_checkin)
                            ->where('data', '<=', $prenotazione->data_checkout)
                            ->get();
        $data = [
            'attivita' => $attivita,
        ];
        return view('prenotazione.attivita.seleziona_attivita', $data);
    }

    public function conferma_attivita(Request $request, $id)
    {
        $lista_attivita = $request->input('attivita');
        $prenotazione = Prenotazione::find($id);
        foreach($lista_attivita as $singola_attivita)
        {
            $prenotazione->attivita()->attach($singola_attivita);
        }
        $cliente_name = User::where('id', $prenotazione->cliente_user_id)->value('name');
        $data = [
            'prenotazione' => $prenotazione,
            'cliente_name' => $cliente_name,
        ];
        return view("prenotazioni.attivita.conferma_attivita", $data);
    }
}
