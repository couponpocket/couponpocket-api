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

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $validityFrom = now();
        $validityTill = clone $validityFrom;
        $validityTill->setMonth($validityFrom->month + 3);

        return [
            'where' => self::WHERE[array_rand(self::WHERE)],
            'points' => self::POINTS[array_rand(self::POINTS)],
            'condition' => $this->faker->words(5, true),
            'ean' => rand(0, 1) ? $this->faker->ean13 : $this->faker->ean8,
            'source' => $this->faker->word(),
            'valid_from' => $validityFrom,
            'valid_till' => $validityTill
        ];
    }
}
