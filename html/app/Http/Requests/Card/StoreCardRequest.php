<?php

namespace App\Http\Requests\Card;

use App\Core\Requests\StoreRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class StoreCardRequest extends StoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): Response
    {
        /** @var User $user */
        $user = Auth::user();

        if ($this->request->get('user_id') === $user->id) {
            return $this->allow();
        }

        return parent::authorize();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'number' => 'required|integer',
            'user_id' => 'required|string|exists:users,id',
            'card_type_id' => 'required|string|exists:card_types,id'
        ];
    }
}
