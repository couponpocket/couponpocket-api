<?php

namespace App\Http\Requests\Auth;

use App\Core\Requests\BaseRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * @method User user(string $guard = null)
 */
class GenerateTokenRequest extends BaseRequest
{
    public function authorize(): Response
    {
        return $this->user() ? $this->deny() : $this->allow();
    }

    public function rules(): array
    {
        return [
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|string|min:6'
        ];
    }
}
