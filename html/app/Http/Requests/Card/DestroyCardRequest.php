<?php

namespace App\Http\Requests\Card;

use App\Core\Requests\DestroyRequest;
use App\Models\Card;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class DestroyCardRequest extends DestroyRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): Response
    {
        /** @var User $user */
        $user = Auth::user();

        /** @var Card $card */
        $card = Card::find($this->route()->parameter('card'));

        if ($card->user_id === $user->id) {
            return $this->allow();
        }

        return parent::authorize();
    }
}
