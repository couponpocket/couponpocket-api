<?php

namespace Database\Factories;

use App\Models\CardType;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CardType::class;

    const COUPON_CATEGORIES = [
        'b33435c2-4f08-43bb-aca9-3a60764143c0',
        'f22959ea-81be-43fd-aba6-d659953c50d9',
        'f678fa75-d004-49dd-a726-016c6128bb68'
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'coupon_category_id' => rand(0, 1) === 0 ? null : self::COUPON_CATEGORIES[array_rand(self::COUPON_CATEGORIES)]
        ];
    }
}
