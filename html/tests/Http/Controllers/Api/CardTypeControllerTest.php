<?php

namespace Tests\Http\Controllers\Api;

use App\Models\CardType;
use App\Models\User;
use Illuminate\Foundation\Application;
use Tests\TestCase;

class CardTypeControllerTest extends TestCase
{
    public function createApplication(): Application
    {
        $app = parent::createApplication();

        CardType::query()->delete();

        return $app;
    }

    public function testIndex()
    {
        /** @var User $user */
        $user = User::factory()
            ->create();

        $token = $user->createToken('auth-token')->plainTextToken;

        CardType::factory()
            ->count(3)
            ->create();

        $this->json('get', '/api/card-types', [], [
            'Authorization' => 'Bearer ' . $token
        ])
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'coupon_category_id'
                ]
            ])
            ->assertJsonCount(3);
    }
}

