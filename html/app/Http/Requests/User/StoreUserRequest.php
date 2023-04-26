<?php

namespace App\Http\Requests\User;

use App\Core\Requests\StoreRequest;

class StoreUserRequest extends StoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|integer|min:1|max:4',
            'password' => 'required|min:8'
        ];
    }
}
