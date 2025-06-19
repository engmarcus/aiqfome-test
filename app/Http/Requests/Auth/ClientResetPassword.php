<?php

namespace App\Http\Requests\Auth;

use App\Data\DTOs\ClientPasswordResetDto;
use App\Data\Mappers\ClientResetMapper;
use App\Support\Helpers\Validation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator as ValidatorForm;
use App\Support\Helpers\Response;
use Illuminate\Validation\Rule;

class ClientResetPassword extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::exists('pgsql.client.clients', 'email'),
            ],
            'password' => 'required|string',
            'newPassword' => 'required|string|min:6',
            'newPasswordConfirmed' => 'required|string|min:6|same:newPassword',
        ];
    }

    public function messages()
    {
        return Validation::generateMessages($this->rules());
    }

    public function getClientData(): ClientPasswordResetDto
    {
        return ClientResetMapper::fromArray($this->validated());
    }

    protected function failedValidation(ValidatorForm $validator)
    {
        Response::validation($validator);
    }

}



