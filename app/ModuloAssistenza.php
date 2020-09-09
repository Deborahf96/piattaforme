<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuloAssistenza extends Model
{
    protected $table = 'modulo_assistenza';
    
    public function cliente()
    {
        return $this->belongsTo('App\Cliente', 'cliente_user_id');
    }
}
