<?php

namespace App\Http\Controllers\SystemControllers;

use App\Http\Controllers\Controller;
use App\Models\Arquivos;
use App\Models\Documentos;
use Illuminate\Http\Request;

class DocumentosController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
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
     * Display the specified resource.
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
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Documentos::find($id);
        $data->delete();
        return response()->json(['msg'=>'Documento deletado com sucesso','data'=>$data]);
    }


    public function addVereadores($idDocumento ,$data ){

        $documento = Documentos::find($idDocumento);
        $documento->vereadores()->attach($data);

    }
    public function addReunioes($idDocumento ,$data ){

        $documento = Documentos::find($idDocumento);
        $documento->reunioes()->attach($data);

    }
}
