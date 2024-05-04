<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $subscription = \App\Models\Subscription::factory()->create();

        $status = $this->faker->randomElement(['PENDING', 'PAID', 'REVOKED']);
        $paidAt = $status === 'PAID' ? $this->faker->dateTimeBetween('-1 year', 'now') : null;

        return [
            'registration_id' => \App\Models\Registration::factory(),
            'subscription_id' => $subscription->id,
            'description' => $this->faker->sentence(),
            'due_date' => $this->faker->date(),
            'paid_at' => $paidAt,
            'value' => $subscription->value,
            'status' => $status,
        ];
    }
}
