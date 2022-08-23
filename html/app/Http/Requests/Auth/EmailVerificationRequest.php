<?php

namespace App\Http\Requests\Auth;

use App\Core\Requests\BaseRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Events\Verified;

/**
 * @method User user(string $guard = null)
 */
class EmailVerificationRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return Response
     */
    public function authorize(): Response
    {
        if ($this->user()->generateEmailValidationCode() !== $this->request->get('code')) {
            return $this->deny();
        }

        return $this->allow();
    }

    /**
     * Fulfill the email verification request.
     */
    public function fulfill()
    {
        if (!$this->user()->hasVerifiedEmail()) {
            $this->user()->markEmailAsVerified();

            event(new Verified($this->user()));
        }
    }
}
