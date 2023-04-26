<?php

namespace App\Http\Controllers\Api;

use App\Core\Controllers\Api\ApiController;
use App\Http\Requests\Coupon\IndexCouponRequest;
use App\Models\Coupon;
use App\Models\User;
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

        $coupons = Coupon::where('valid_from', '<=', $now->format('Y-m-d'))
            ->where('valid_till', '>=', $now->format('Y-m-d'))
            ->where('visibility', 1)
            ->orderBy('condition', 'ASC')
            ->orderByRaw('LENGTH(points) DESC, points DESC')
            ->orderBy('valid_till', 'ASC');


        if ($request->user()) {
            /** @var User $user */
            $user = $request->user();

            if ($user->isAdmin() || $user->isModerator()) {
                $coupons->orWhere('visibility', 0);
            }
        }

        return response()->json($coupons->get());
    }
}
