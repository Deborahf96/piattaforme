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
}
