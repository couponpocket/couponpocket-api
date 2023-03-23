<?php

namespace App\Http\Requests\Auth;

use App\Core\Requests\BaseRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * @method User user(string $guard = null)
 */
class GenerateTokenRequest extends BaseRequest
{
    public function authorize(): Response
    {
        $user = User::where('email', $this->request->get('email'))->first();

        if (!($user instanceof User) || !Hash::check($this->request->get('password'), $user->password)) {
            return $this->deny(__('auth.failed'), 401);
        }

        return $this->user() ? $this->deny() : $this->allow();
    }

    public function rules(): array
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6'
        ];
    }
}
