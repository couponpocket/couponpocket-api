<?php

namespace App\Http\Requests\CouponCategory;

use App\Core\Requests\IndexRequest;
use Illuminate\Auth\Access\Response;

class IndexCouponCategoryRequest extends IndexRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): Response
    {
        return $this->allow();
    }
}
