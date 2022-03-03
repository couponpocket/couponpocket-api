<?php

namespace App\Http\Requests\User;

use App\Core\Requests\UpdateRequest;

class UpdateUserRequest extends UpdateRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ];
    }
}
