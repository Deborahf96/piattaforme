<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dipendente extends Model
{
    protected $table = 'dipendente';
    public $timestamps = false; 

    public function utente()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
