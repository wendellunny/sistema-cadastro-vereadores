<?php

namespace App\Http\Controllers\SystemControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\VereadorRequest;
use App\Mail\registerSuccessful;
use App\Models\Vereadores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VereadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataModel = Vereadores::all();
        return response()->json(['vereadores_cadastrados'=>$dataModel],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VereadorRequest $request)
    {
        $dataRequest = $request->all();
        $dataModel = Vereadores::create($dataRequest);
        Mail::send(new registerSuccessful($request));
       
        
      
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataModel = Vereadores::find($id);
        $dataModel->documentos;
        return response()->json(["Vereador"=>$dataModel],200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VereadorRequest $request, $id)
    {
        $data = $request->all();
        $dataModel = Vereadores::findOrFail($id);
        $dataModel->update($data);
        return response()->json(['msg' => 'Vereador Atualizado com Sucesso','data'=>$data]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Vereadores::find($id);
        $data->delete();
        return response()->json(['msg'=>'Vereador deletado com sucesso','data'=>$data]);
    }
}
