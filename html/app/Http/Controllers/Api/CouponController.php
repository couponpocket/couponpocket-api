<?php

namespace App\Http\Controllers\Api;

use App\Core\Controllers\Api\ApiController;
use App\Models\Coupon;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CouponController extends ApiController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $now = new DateTime();

        return response()->json([
            'status' => 'true',
            'items' => Coupon::where('valid_from', '<=', $now->format('Y-m-d'))
                ->where('valid_till', '>=', $now->format('Y-m-d'))
                ->orderBy('condition', 'ASC')
                ->orderByRaw('LENGTH(points) DESC, points DESC')
                ->orderBy('valid_till', 'ASC')
                ->get()
        ]);
    }
}
