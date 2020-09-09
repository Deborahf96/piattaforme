<?php

namespace App\Http\Controllers;

class Enums
{
    public static function ditta_esterna_categoria_enum()
    {
        return [
            'Manutenzione'=> 'Manutenzione',
            'Servizio navetta' => 'Servizio navetta',
            'Tour operator' => 'Tour operator',
        ];
    }

    public static function camera_piano_enum()
    {
        return [
            'Piano terra' => 'Piano terra',
            'Primo piano' => 'Primo piano',
        ];
    }

    public static function attivita_tipologia_enum()
    {
        return [
            'Servizio navetta' => 'Servizio navetta',
            'Visita guidata' => 'Visita guidata',
        ];
    }

    public static function dipendente_ruolo_enum()
    {
        return [
            'Addetto alle pulizie' => 'Addetto alle pulizie',
            'Addetto alla manutenzione' => 'Addetto alla manutenzione',
            'Cuoco' => 'Cuoco',
            'Receptionist' => 'Receptionist',
            'Responsabile area esterna' => 'Responsabile area esterna',
            'Responsabile sala' => 'Responsabile sala',
        ];
    }

    public static function tipo_contratto_enum()
    {
        return [
            'A chiamata' => 'A chiamata',
            'A tempo determinato' => 'A tempo determinato',
            'A tempo indeterminato' => 'A tempo indeterminato',
            'Apprendistato' => 'Apprendistato',
            'Part-time' => 'Part-time',
        ];
    }

    public static function metodo_pagamento_enum()
    {
        return [
            'Bonifico bancario' => 'Bonifico bancario',
            'Carta di credito' => 'Carta di credito',
            'Paga in struttura' => 'Paga in struttura',
        ];
    }

    public static function tipo_assistenza_enum()
    {
        return [
            'Inviare un reclamo' => 'Inviare un reclamo',
            'Richiedere informazioni' => 'Richiedere informazioni',
        ];
    }

}
