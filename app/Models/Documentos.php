<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentos extends Model
{
    use HasFactory;
    protected $table = 'documentos';
    protected $primarykey = 'id';

    protected $fillable = [
        'titulo',
        'tipo',
        'descricao',
        'data_de_publicacao',
        'arquivo_documento'
    ];
}
