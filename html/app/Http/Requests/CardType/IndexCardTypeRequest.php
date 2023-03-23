<?php

namespace App\Http\Requests\CardType;

use App\Core\Requests\IndexRequest;
use Illuminate\Auth\Access\Response;

class IndexCardTypeRequest extends IndexRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): Response
    {
        return $this->allow();
    }
}
