<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prenotazione extends Model
{
    protected $table = 'prenotazione';
    public $timestamps = false;

    public function camera()
    {
        return $this->belongsTo('App\Camera', 'camera_id');
    }

    public function cliente_user_id()
    {
        return $this->belongsTo('App\Cliente', 'cliente_user_id');
    }

    public function attivita()
    {
        return $this->belongsToMany('App\Attivita', 'prenotazione_attivita', 'prenotazione_id', 'attivita_id');
    }
}


