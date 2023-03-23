<?php

namespace Tests\Http\Controllers\Api;

use App\Models\Coupon;
use App\Models\User;
use Tests\TestCase;

class CouponControllerTest extends TestCase
{
    public function testIndex()
    {
        /** @var User $user */
        Coupon::factory()
            ->count(20)
            ->create();

        $this->json('get', '/api/coupons')
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'points',
                    'condition',
                    'ean',
                    'source',
                    'valid_from',
                    'coupon_category_id'
                ]
            ])
            ->assertJsonCount(20);
    }
}

