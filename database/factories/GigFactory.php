<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gig>
 */
class GigFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'company_id' => Company::factory(),
            'name' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'start' => $this->faker->dateTime()->format('Y-m-d H:i:s'),
            // 'end' => '',
            'number_of_position' =>  $this->faker->randomDigit(0, 250000),
            'pay_per_hour' =>  $this->faker->randomDigit(),
            'status' =>  $this->faker->boolean(),
        ];
    }
}
