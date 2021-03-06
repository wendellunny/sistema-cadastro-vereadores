<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arquivos extends Model
{
    use HasFactory;
    protected $table = 'arquivos';
    protected $primarykey = 'id';
    protected $fillable = [
        'nome',
        'caminho',
        'extensao',
        'tamanho'
    ];
}
