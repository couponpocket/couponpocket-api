<?php

namespace App\Http\Controllers\Api;

use App\Core\Controllers\Api\ApiController;
use App\Models\CouponCategory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponCategoryController extends ApiController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $sortCoupon = function (HasMany $q) {
            $q->orderBy('condition', 'ASC')
                ->orderByRaw('LENGTH(points) DESC, points DESC')
                ->orderBy('valid_till', 'ASC');
        };

        return response()->json([
            'status' => 'true',
            'items' => CouponCategory::with(['coupons' => $sortCoupon])
                ->orderBy('name', 'ASC')
                ->get()
        ]);
    }
}
