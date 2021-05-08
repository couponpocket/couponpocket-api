<?php

namespace App\Http\Controllers\Api;

use App\Core\Controllers\Api\ApiController;
use App\Models\CouponCategory;
use DateTime;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        $now = new DateTime();

        $sortCoupon = function (HasMany $q) use ($now) {
            $q->where('valid_from', '<=', $now->format('Y-m-d'))
                ->where('valid_till', '>=', $now->format('Y-m-d'))
                ->orderBy('condition', 'ASC')
                ->orderByRaw('LENGTH(points) DESC, points DESC')
                ->orderBy('valid_till', 'ASC');
        };

        return response()->json([
            'status' => 'true',
            'items' => CouponCategory::with(['coupons' => $sortCoupon])
                ->whereHas('coupons', function ($q) use ($now) {
                    $q->where('valid_from', '<=', $now->format('Y-m-d'))
                        ->where('valid_till', '>=', $now->format('Y-m-d'));
                })
                ->orderBy('name', 'ASC')
                ->get()
        ]);
    }
}
