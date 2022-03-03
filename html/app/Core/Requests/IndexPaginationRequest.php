<?php

namespace App\Core\Requests;

class IndexPaginationRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'page' => 'integer|min:0',
            'perPage' => 'integer|min:0',
            'sortKey' => 'string',
            'sortOrder' => 'in:asc,desc'
        ];
    }
}
