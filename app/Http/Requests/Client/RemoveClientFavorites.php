<?php

namespace App\Http\Requests\Client;

use Illuminate\Contracts\Validation\Validator as ValidatorForm;
use Illuminate\Foundation\Http\FormRequest;
use App\Support\Helpers\Response;
use App\Support\Helpers\Validation;

class RemoveClientFavorites extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->id() === (int) $this->route('clientId');
    }

    public function rules(): array
    {
        return [
            'productId' => 'required|integer'
        ];
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

    public function validationData(): array
    {
       return array_merge($this->all(), [
            'productId' => $this->route('productId'),
        ]);
    }
    public function getProductId(): int
    {
        return (int) $this->validated()['productId'];
    }
    public function getClientId(): int
    {
        return (int) auth()->id();
    }

}
