<?php

namespace App\Core\Requests;

class IndexRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'sortKey' => 'string',
            'sortOrder' => 'in:asc,desc'
        ];
    }
}
