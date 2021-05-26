<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attivita extends Model
{
    protected $table = 'attivita';
    public $timestamps = false;

    public function ditta_esterna()
    {
        return $this->belongsTo('App\DittaEsterna', 'ditta_esterna_id');
    }

    public function prenotazioni()
    {
        return $this->belongsToMany('App\Prenotazione', 'prenotazione_attivita', 'attivita_id', 'prenotazione_id');
    }
}
