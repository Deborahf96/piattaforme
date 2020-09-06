<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dipendente extends Model
{
    protected $table = 'dipendente';
    public $timestamps = false;
    protected $primaryKey = 'email';
    public $incrementing = false; 
}
