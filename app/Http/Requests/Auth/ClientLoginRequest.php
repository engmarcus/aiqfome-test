<?php

namespace App\Http\Requests\Auth;

use App\Support\Helpers\Validation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator as ValidatorForm;
use App\Support\Helpers\Response;
use Illuminate\Validation\Rule;

class ClientLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages()
    {
        return Validation::generateMessages($this->rules());
    }

    protected function failedValidation(ValidatorForm $validator)
    {
        Response::validation($validator);
    }

}



