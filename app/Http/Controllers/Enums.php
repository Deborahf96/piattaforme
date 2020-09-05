<?php

namespace App\Http\Controllers;

class Enums
{
    public static function ditta_esterna_categoria_enum()
    {
        return [
            'Manutenzione '=> 'Manutenzione',
            'Servizio navetta' => 'Servizio navetta',
            'Tour operator' => 'Tour operator',
        ];
    }

    public static function ditta_esterna_tipo_contratto_enum()
    {
        return [
            'A chiamata' => 'A chiamata',
            'A tempo determinato' => 'A tempo determinato',
            'A tempo indeterminato' => 'A tempo indeterminato',
            'Apprendistato' => 'Apprendistato',
            'Part-time' => 'Part-time',
        ];
    }

    public static function camera_disponibilità_enum()
    {
        return [
            'Disponibile' => 'Disponibile',
            'Non disponibile' => 'Non disponibile',
        ];
    }

    public static function camera_piano_enum()
    {
        return [
            'Piano terra' => 'Piano terra',
            'Primo piano' => 'Primo piano',
        ];
    }

    public static function cliente_metodo_pagamento_enum()
    {
        return [
            'Bonifico bancario' => 'Bonifico bancario',
            'Carta di credito' => 'Carta di credito',
            'Paga in struttura' => 'Paga in struttura',
        ];
    }

    public static function attivita_tipologia_enum()
    {
        return [
            'Servizio navetta' => 'Servizio navetta',
            'Visita guidata' => 'Visita guidata',
        ];
    }
}
