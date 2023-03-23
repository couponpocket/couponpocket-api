<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        Coupon::factory(50)->create();

        $users = User::factory()
            ->count(10)
            ->create();

        foreach ($users as $user) {
            Card::factory()
                ->count(rand(1, 4))
                ->create([
                    'user_id' => $user->id
                ]);
        }
    }
}
