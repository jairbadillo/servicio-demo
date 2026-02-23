<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    protected $fillable = [
        'name',
        'date_expiration',
        'balance',
        'status',
    ];


    // Laravel detecta métodos que tengan este patrón:
    // get + Nombre + Attribute
    // Y crea un atributo virtual automáticamente llamdo en este caso "balance_formatted".
    public function getBalanceFormattedAttribute()
    {
        return number_format($this->balance, 0, ',', '.');
    }
}
