<?php

namespace App\Http\Controllers\Api;

use App\Core\Controllers\Api\ApiController;
use App\Core\Traits\IndexTrait;
use App\Http\Requests\CouponCategory\IndexCouponCategoryRequest;
use App\Models\CouponCategory;
use Illuminate\Http\JsonResponse;

class CouponCategoryController extends ApiController
{
    use IndexTrait {
        index as baseIndex;
    }

    protected string $modelClass = CouponCategory::class;

    /**
     * @param IndexCouponCategoryRequest $request
     * @return JsonResponse
     */
    public function index(IndexCouponCategoryRequest $request): JsonResponse
    {
        return $this->baseIndex($request);
    }
}
