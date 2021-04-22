<?php

namespace App\Http\Controllers\SystemControllers;

use App\Http\Controllers\Controller;
use App\Models\Arquivos;
use App\Models\Documentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentosController extends Controller
{
    /**
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataModel = Documentos::all();
        foreach ($dataModel as $key => $value) {
            $dataModel[$key]->arquivo_documento = Arquivos::find($value->arquivo_documento);
  
        }
    
     
        return response()->json(["Documentos Publicados"=>$dataModel],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE);
    }

    /**
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formData = $request->all();
        
        $data = [
            "titulo" => $formData['titulo'],
            "tipo" => $formData['tipo'],
            "descricao" => $formData['descricao'],
            "data_de_publicacao" => date('Y-m-d'),
        ];

        $documentoFileName = "$data[tipo]". "_pub_" . date("d-m-Y_H-i-s");
        $data['arquivo_documento'] = 
            ArquivosController::UploadFiles(
                $request->arquivo_documento, 
                $documentoFileName, 
                '/public/documentos/'. $data['tipo'] . "/" . $data['data_de_publicacao'] , 
                ['pdf','docx']
            );

        $dataModel = Documentos::create($data);

        if(!empty($formData['vereadores_colaboradores'])){
            $this->addVereadores($dataModel->id , $formData['vereadores_colaboradores']);
        }
        
        if(!empty($formData['reunioes'])){
            $this->addReunioes($dataModel->id , $formData['reunioes']);
        }
        
        
    }

    /**
     * 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataModel = Documentos::find($id);
        $dataModel->vereadores;
        $dataModel->reunioes;
        $dataModel->arquivo_documento = Arquivos::find($dataModel->arquivo_documento);
        return response()->json(["Documento"=>$dataModel],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE);

       
    }
    
    

    /**
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $dataModel = Documentos::findOrFail($id);
        $dataModel->update($data);
        return response()->json(['msg' => 'Documento Atualizado com Sucesso','data'=>$data]);
    }

    /**
     * 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Documentos::find($id);
        $arquivoDocumento = Arquivos::find($data->arquivo_documento)->caminho;
        $arquivoDocumento = str_replace("/storage","public",$arquivoDocumento);

        Storage::delete($arquivoDocumento);
     
        $data->delete();
        return response()->json(['msg'=>'Documento deletado com sucesso','data'=>$data]);
    }

    /* 
        Método que adiciona vereadores ao relacionamento n:m de documentos_vereadores
    */
    public function addVereadores($idDocumento ,$data ){

        $documento = Documentos::find($idDocumento);
        $documento->vereadores()->attach($data);

    }
    public function addReunioes($idDocumento ,$data ){

        $documento = Documentos::find($idDocumento);
        $documento->reunioes()->attach($data);

    }
}
