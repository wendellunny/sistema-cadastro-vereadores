<?php

namespace App\Http\Controllers\SystemControllers;

use App\Http\Controllers\Controller;
use App\Models\Arquivos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArquivosController extends Controller
{
    
    public static function UploadFiles($file,$filename,$path,$extensions = []){
        if($file->isValid()){
            foreach ($extensions as $key => $value) {
                if($file->extension() === $value){
                    $namefile = $filename . "." . $file->extension();
                    $pathUpload = $file->storeAs($path , $namefile);
                    $size = intVal(round($file->getSize() / 1000));
                    
                    $data = [
                        'nome' => $filename,
                        'caminho' => Storage::url($pathUpload) ,
                        'extensao' => $file->extension(),
                        'tamanho' => $size
                    ];
                

                    $dataModel = Arquivos::create($data);
                    return $dataModel->id;
                }
            }
                    
        }
    }

    public function index()
    {
       
    }
    public function show($id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
