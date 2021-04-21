<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class VereadorRequest extends FormRequest
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
            'nome' => ['required','min:3','max:70'],
            'email' => ['required','unique:vereadores,email','email:rfc,dns'],
            'numero_de_urna' => ['required','unique:vereadores,numero_de_urna'],
            'quantidade_de_votos' => ['required'],
            'data_nascimento' => ['required']
                    
        ];
    }

     public function messages(){
        return [
            "required" => "Este campo é obrigatório",
            "min" => "Este campo requer pelo menos :min caracteres",
            "max" => "Este campo requer no maximo :max caracteres",
            'email' => "Email Inválido",
            'email.unique' => 'Email já registrado',
            'numero_de_urna.unique' => 'Numero de Urna já registrado'
        ];   
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(["errors"=>$validator->errors()], 422));
    }
}
