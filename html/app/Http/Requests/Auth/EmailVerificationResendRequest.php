<?php

namespace App\Http\Requests\Auth;

use App\Core\Requests\BaseRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * @method User user(string $guard = null)
 */
class EmailVerificationResendRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return Response
     */
    public function authorize(): Response
    {
        if ($this->user()->hasVerifiedEmail()) {
            return $this->deny(__('verification.failed.already_verified'), 403);
        }

        return $this->allow();
    }
}
