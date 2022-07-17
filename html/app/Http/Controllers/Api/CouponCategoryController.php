<?php

namespace App\Http\Controllers\Api;

use App\Core\Controllers\Api\ApiController;
use App\Http\Requests\CouponCategory\IndexCouponCategoryRequest;
use App\Models\CouponCategory;
use DateTime;
use Illuminate\Http\JsonResponse;

class CouponCategoryController extends ApiController
{
    /**
     * @param IndexCouponCategoryRequest $request
     * @return JsonResponse
     */
    public function index(IndexCouponCategoryRequest $request): JsonResponse
    {
        $now = new DateTime();

        return response()->json(CouponCategory::whereHas('coupons',
            function ($q) use ($now) {
                $q->where('valid_from', '<=', $now->format('Y-m-d'))
                    ->where('valid_till', '>=', $now->format('Y-m-d'));
            })
            ->orderBy('name', 'ASC')
            ->get()
        );
    }
}
