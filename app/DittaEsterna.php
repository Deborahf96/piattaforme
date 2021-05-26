<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DittaEsterna extends Model
{
    protected $table = 'ditta_esterna';
    public $timestamps = false;

    public function getDittaAttribute()
    {
        return $this->categoria . " - " . $this->nome;
    }
}
