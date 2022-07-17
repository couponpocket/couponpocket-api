<?php

namespace App\Http\Controllers\Api;

use App\Core\Controllers\Api\ApiController;
use App\Http\Requests\Coupon\IndexCouponRequest;
use App\Models\Coupon;
use DateTime;
use Illuminate\Http\JsonResponse;

class CouponController extends ApiController
{
    /**
     * @param IndexCouponRequest $request
     * @return JsonResponse
     */
    public function index(IndexCouponRequest $request): JsonResponse
    {
        $now = new DateTime();

        return response()->json(Coupon::where('valid_from', '<=', $now->format('Y-m-d'))
            ->where('valid_till', '>=', $now->format('Y-m-d'))
            ->orderBy('condition', 'ASC')
            ->orderByRaw('LENGTH(points) DESC, points DESC')
            ->orderBy('valid_till', 'ASC')
            ->get()
        );
    }
}
