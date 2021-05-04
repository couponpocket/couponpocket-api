<?php

namespace App\Http\Controllers\Api;

use App\Core\Controllers\Api\ApiController;
use App\Models\CouponCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CouponCategoryController extends ApiController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'true',
            'items' => CouponCategory::with(['coupons' => function ($q) {
                $q->orderBy('condition', 'ASC')
                    ->orderBy('points', 'DESC');
            }])
                ->get()
        ]);
    }
}
