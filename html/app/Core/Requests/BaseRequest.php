<?php

namespace App\Core\Requests;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BaseRequest extends FormRequest implements BaseRequestInterface
{
    use HandlesAuthorization;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): Response
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user || !$user->isAdmin()) {
            return $this->deny();
        }

        return $this->allow();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [];
    }
}
