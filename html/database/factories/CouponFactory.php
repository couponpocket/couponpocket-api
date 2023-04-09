<?php

namespace Database\Factories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Coupon::class;

    const WHERE = [
        'Rewe',
        'Real',
        'Penny',
        'Netto',
        'Fressnapf',
        'Edeka'
    ];

    const POINTS = [
        '15FACH',
        '20FACH',
        '5FACH',
        '250EXTRA',
        '500EXTRA',
        '1000EXTRA'
    ];

    const COUPON_CATEGORIES = [
        'b33435c2-4f08-43bb-aca9-3a60764143c0', // ARAL
        'f22959ea-81be-43fd-aba6-d659953c50d9', // REWE
        '08f7d59e-f921-465b-a162-194880dfcb2f' // Burger King
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $validityFrom = now();
        $validityTill = clone $validityFrom;
        $validityTill->setMonth($validityFrom->month + 3);

        return [
            'points' => self::POINTS[array_rand(self::POINTS)],
            'condition' => $this->faker->words(5, true),
            'ean' => $this->faker->ean13(),
            'source' => $this->faker->word(),
            'valid_from' => $validityFrom,
            'valid_till' => $validityTill,
            'coupon_category_id' => self::COUPON_CATEGORIES[array_rand(self::COUPON_CATEGORIES)]
        ];
    }
}
