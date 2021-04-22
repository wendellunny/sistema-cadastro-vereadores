<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reunioes extends Model
{
    use HasFactory;
    protected $table = 'reunioes';
    protected $primarykey ='id';
    protected $fillable = [
        'tipo',
        'data_reuniao',
        'arquivo_pauta',
        'arquivo_ata'
    ];
}
