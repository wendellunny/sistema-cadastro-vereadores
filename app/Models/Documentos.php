<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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

    public function vereadores(){
        return $this->belongsToMany(Vereadores::class,'documentos_vereadores','id_documentos','id_vereadores');
    }

    public function reunioes(){
        return $this->belongsToMany(Reunioes::class,'documentos_reunioes','id_documentos','id_reunioes');
    }
}
