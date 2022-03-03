<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\User\StoreUserRequest;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class RegisterRequest extends StoreUserRequest
{
    public function authorize(): Response
    {
        return Auth::check() ? $this->deny() : $this->allow();
    }

    public function rules(): array
    {
        $parentRules = parent::rules();

        unset($parentRules['role']);

        return $parentRules;
    }
}
