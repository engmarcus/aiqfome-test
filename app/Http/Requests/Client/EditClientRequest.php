<?php

namespace App\Http\Requests\Client;

use App\Data\DTOs\ClientEditDto;
use App\Data\Mappers\ClientEditMapper;
use Illuminate\Contracts\Validation\Validator as ValidatorForm;
use Illuminate\Foundation\Http\FormRequest;
use App\Support\Helpers\Response;
use App\Support\Helpers\Validation;

class EditClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->id() === (int) $this->route('clientId');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string'
        ];
    }
    public function getClientEditData(): ClientEditDto
    {
        return ClientEditMapper::fromArray($this->validated());
    }

    public function messages(): array
    {
        return Validation::generateMessages($this->rules());
    }

    protected function failedAuthorization()
    {
        Response::forbidden();
    }

    protected function failedValidation(ValidatorForm $validator)
    {
        Response::validation($validator);
    }



}
