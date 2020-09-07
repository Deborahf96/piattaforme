<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';
    public $timestamps = false;
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    public function utente()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
