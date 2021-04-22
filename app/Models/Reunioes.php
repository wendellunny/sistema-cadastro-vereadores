<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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

    public function documentos(){
        return $this->belongsToMany(Documentos::class,'documentos_reunioes','id_reunioes','id_documentos');
    }
}
