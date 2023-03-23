<?php

namespace Database\Factories;

use App\Models\Card;
use App\Models\CardType;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Card::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'number' => $this->faker->ean13(),
            'card_type_id' => fn() => CardType::factory()->create()->id
        ];
    }
}
