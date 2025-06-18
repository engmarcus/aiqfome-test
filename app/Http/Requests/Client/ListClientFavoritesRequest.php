<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use App\Support\Helpers\Response;

class ListClientFavoritesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->id() === (int) $this->route('clientId');
    }

    public function rules(): array
    {
        return [];
    }

    protected function failedAuthorization()
    {
        Response::forbidden();
    }

}



