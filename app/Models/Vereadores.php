<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vereadores extends Model
{
    use HasFactory;

    protected $table = 'vereadores';
    protected $primarykey = 'id';
    protected $fillable = [
        'nome',
        'data_nascimento',
        'email',
        'numero_de_urna',
        'quantidade_de_votos'
    ];
}
