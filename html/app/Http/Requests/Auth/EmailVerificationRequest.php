<?php

namespace App\Http\Requests\Auth;

use App\Core\Requests\BaseRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Validation\ValidationException;

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
        if ($this->user()->hasVerifiedEmail()) {
            return $this->deny(__('verification.failed.already_verified'), 403);
        }

        if ($this->user()->getEmailValidationCode() !== $this->request->get('code')) {
            return $this->deny(__('verification.failed.code_wrong'), 400);
        }

        return $this->allow();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|min:6'
        ];
    }
}
