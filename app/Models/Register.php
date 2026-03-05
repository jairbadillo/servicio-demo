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

    protected $casts = [
        'date_expiration' => 'datetime'
    ];


    // Laravel detecta métodos que tengan este patrón:
    // get + Nombre + Attribute
    // Y crea un atributo virtual automáticamente llamado en este caso "balance_formatted".
    public function getBalanceFormattedAttribute()
    {
        return number_format($this->balance, 2, ',', '.');
    }

    public function getDateExpirationFormattedAttribute()
    {
        return $this->date_expiration->format('Y-m-d');
    }
}
