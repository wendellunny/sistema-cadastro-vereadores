<?php

namespace App\Http\Controllers\SystemControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReunioesRequest;
use App\Models\Arquivos;
use App\Models\Reunioes;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReunioesController extends Controller
{
    /**
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataModel = Reunioes::all();
        foreach ($dataModel as $key => $value) {
            $dataModel[$key]->arquivo_pauta = Arquivos::find($value->arquivo_pauta);
            $dataModel[$key]->arquivo_ata = Arquivos::find($value->arquivo_ata);
  
        }
    
     
        return response()->json(["reunioes"=>$dataModel],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE);
    }

    /**
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReunioesRequest $request)
    {
        $data =[
            "tipo"=>$request->tipo,
            "data_reuniao"=>$request->data_reuniao,
        ];

        $pautaFileName = "pauta_reuniao_" . $data['data_reuniao'] . "_pub_" . date("d-m-Y_H-i-s");
        $data['arquivo_pauta'] = 
            ArquivosController::UploadFiles(
                $request->arquivo_pauta, 
                $pautaFileName, 
                '/public/pauta/'. $data['data_reuniao'] , 
                ['pdf','docx']
            );

        $ataFileName = "ata_reuniao_" . $data['data_reuniao'] . "_pub_" . date('d-m-Y_H-i-s');
        $data['arquivo_ata'] = 
            ArquivosController::UploadFiles(
                $request->arquivo_ata, 
                $ataFileName, 
                '/public/ata/'. $data['data_reuniao'] , 
                ['pdf','docx']
            );

        $dataModel = Reunioes::create($data);

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataModel = Reunioes::find($id);
        $dataModel->documentos;
        return response()->json(["Reuniao"=>$dataModel],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReunioesRequest $request, $id)
    {
        $data = $request->all();
        $dataModel = Reunioes::findOrFail($id);
        $dataModel->update($data);
        return response()->json(['msg' => 'Reuni??o Atualizada com Sucesso','data'=>$data]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Reunioes::find($id);
        
        $arquivoPauta = Arquivos::find($data->arquivo_pauta)->caminho;
        $arquivoPauta = str_replace("/storage","public",$arquivoPauta);
        $arquivoAta = Arquivos::find($data->arquivo_ata)->caminho;
        $arquivoAta = str_replace("/storage","public",$arquivoAta);
        Storage::delete($arquivoPauta);
        Storage::delete($arquivoAta);
        $data->delete();
        return response()->json(['msg'=>'Reuni??o deletada com sucesso','data'=>$data]);
    }
}
