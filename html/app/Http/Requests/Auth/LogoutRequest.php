<?php

namespace App\Http\Requests\Auth;

use App\Core\Requests\BaseRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * @method User user(string $guard = null)
*/
class LogoutRequest extends BaseRequest
{
    public function authorize(): Response
    {
        return $this->user() ? $this->allow() : $this->deny();
    }

    public function rules(): array
    {
        return [];
    }
}
