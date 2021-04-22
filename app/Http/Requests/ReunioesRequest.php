<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReunioesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "tipo" => ['required','in:Ordinária,Extraordinária'],
            "data_reuniao" => ['required'],
            "arquivo_pauta" => ["required",'mimes:pdf,docx','max:20000'],
            "arquivo_ata" => ["required",'mimes:pdf,docx','max:20000'],
        ];
    }

    public function messages(){
        return [
            "required" => "Este campo é obrigatório",
            "mimes" => "Formato não suportado. Formatos exigidos : pdf,docx",
            "max" => "Tamanho não suportado. Tamanho máximo exido: 20mb",
            'in' => "Apenas é aceito os tipos de reunião: Ordinária e Extraordinária",
        ];   
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(["errors"=>$validator->errors()], 422,['Content-Type' => 'application/json;charset=utf8'],JSON_UNESCAPED_UNICODE));
    }
}
