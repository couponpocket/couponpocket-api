<?php

namespace App\Http\Requests\Card;

use App\Core\Requests\UpdateRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class UpdateCardRequest extends UpdateRequest
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
            'number' => 'required|number',
            'user_id' => 'required|integer|exists:users,id',
            'card_type_id' => 'required|integer|exists:card_type,id'
        ];
    }
}
