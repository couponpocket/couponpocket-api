<?php

namespace App\Http\Requests\Auth;

use App\Core\Requests\BaseRequest;
use Illuminate\Auth\Access\Response;

class GenerateTokenRequest extends BaseRequest
{
    public function authorize(): Response
    {
        return $this->allow();
    }

    public function rules(): array
    {
        return [
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|string|min:6'
        ];
    }
}
