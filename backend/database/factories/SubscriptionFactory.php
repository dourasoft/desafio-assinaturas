<?php

namespace Database\Factories;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'registration_id' => \App\Models\Registration::factory(),
            'description' => $this->faker->sentence(),
            'value' => $this->faker->numberBetween(10, 1000),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
