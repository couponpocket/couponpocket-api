<?php

namespace App\Core\Requests;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class BaseRequest extends FormRequest implements BaseRequestInterface
{
    use HandlesAuthorization;

    /**
     * Validate the class instance.
     *
     * @return void
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function validateResolved(): void
    {
        $this->prepareForValidation();

        $instance = $this->getValidatorInstance();

        if ($instance->fails()) {
            $this->failedValidation($instance);
        }

        $this->passedValidation();

        if (! $this->passesAuthorization()) {
            $this->failedAuthorization();
        }
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): Response
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return $this->allow();
        }

        return $this->deny();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [];
    }
}
