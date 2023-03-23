<?php

namespace App\Http\Requests\User;

use App\Core\Requests\DestroyRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class DestroyUserRequest extends DestroyRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): Response
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();

        $user = User::findOrFail($this->route()->parameter('user'));

        if ($currentUser->id === $user->id) {
            return $this->deny('A user cannot delete himself');
        }

        return parent::authorize();
    }
}
