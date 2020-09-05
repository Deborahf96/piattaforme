<?php

namespace App\Http\Controllers;

class Enums
{
    public static function ditta_esterna_categoria_enum()
    {
        return [
            'Manutenzione'=>'Manutenzione',
            'Servizio navetta'=>'Servizio navetta',
            'Tour operator' => 'Tour operator',
        ];
    }

    public static function camera_disponibilità_enum()
    {
        return [
            'Disponibile'=>'Disponibile',
            'Non disponibile' => 'Non disponibile',
        ];
    }

    public static function camera_piano_enum()
    {
        return [
            'Piano terra'=>'Piano terra',
            'Primo piano' => 'Primo piano',
        ];
    }

    public static function cliente_metodo_pagamento_enum()
    {
        return [
            'Carta di credito' => 'Carta di credito',
            'Bonifico bancario'=>'Bonifico bancario',
            'Contrassegno'=>'Contrassegno',
        ];
    }
}
