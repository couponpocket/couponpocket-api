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

        return response()->json([
            'status' => 'true',
            'items' => CouponCategory::whereHas('coupons', function ($q) use ($now) {
                    $q->where('valid_from', '<=', $now->format('Y-m-d'))
                        ->where('valid_till', '>=', $now->format('Y-m-d'));
                })
                ->orderBy('name', 'ASC')
                ->get()
        ]);
    }
}
