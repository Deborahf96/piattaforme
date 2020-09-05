<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DittaEsterna extends Model
{
    protected $table = 'ditta_esterna';
    public $timestamps = false;         //per non usare i timestamps, va messo in tutti i model se eliminiamo il timestamp
    protected $primaryKey = 'partita_iva';       //per non controllare l'id, visto che la chiave è partita iva
    public $incrementing = false;
}
