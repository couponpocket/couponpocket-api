<?php

namespace App\Http\Requests\Auth;

use App\Core\Requests\BaseRequest;
use Illuminate\Auth\Access\Response;

class LogoutRequest extends BaseRequest
{
    public function authorize(): Response
    {
        return $this->allow();
    }

    public function rules(): array
    {
        return [];
    }
}
